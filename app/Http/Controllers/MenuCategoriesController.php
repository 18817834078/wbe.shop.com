<?php

namespace App\Http\Controllers;

use App\model\Menu;
use App\model\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MenuCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    //展示
    public function index(){
        $menu_categories=MenuCategory::where('shop_id','=',auth()->user()->shop_id)->paginate(5);
        return view('menu_category/index',['menu_categories'=>$menu_categories]);
    }
    public function show(MenuCategory $menu_category){
        $menus=Menu::where('category_id','=',$menu_category->id)->paginate(5);
        return view('menu_category/show',['menus'=>$menus]);
    }
    //添加
    public function create(){
        $is_selected=0;
        if (!MenuCategory::where('shop_id','=',auth()->user()->shop_id)->sum('is_selected')){
            $is_selected=1;
        }
        return view('menu_category/create',['is_selected'=>$is_selected]);
    }
    public function store(Request  $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
        ], [
            'name.required' => '请输入菜品分类名字',
            'name.max' => '菜品分类名字过长',
        ]);
        if (!$request->description) {
            $request->description = '暂无';
        }
        MenuCategory::create([
            'name' => $request->name,
            'type_accumulation' => uniqid(),
            'shop_id' => auth()->user()->shop_id,
            'description' => $request->description,
            'is_selected' => $request->is_selected,
        ]);
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }


        session()->flash('success', '添加成功');
        return redirect()->route('menu_categories.index');

    }
    //删除
    public function destroy(MenuCategory $menu_category){
        $menus=Menu::where('category_id','=',$menu_category->id)->first();
        if ($menu_category->is_selected==1){
            return back()->with('danger','此分类为默认分类,不可删除');
        }
        if ($menus){
            return back()->with('danger','此分类内仍有菜品,不可删除');
        }
        $menu_category->delete();
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }

        session()->flash('success','删除成功');
        return redirect()->route('menu_categories.index');
    }
    //修改
    public function edit(MenuCategory $menu_category){
        return view('menu_category/edit',['menu_category'=>$menu_category]);
    }
    public function update(Request $request,MenuCategory $menu_category){
        $this->validate($request, [
            'name' => 'required|max:50',
        ], [
            'name.required' => '请输入菜品分类名字',
            'name.max' => '菜品分类名字过长',
        ]);
        if (!$request->description) {
            $request->description = '暂无';
        }
        $menu_category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }

        session()->flash('success','修改成功');
        return redirect()->route('menu_categories.index');

    }
    public function default(MenuCategory $menu_category){
        $menu_categories=MenuCategory::where('shop_id','=',auth()->user()->shop_id);
        $menu_categories->where('is_selected','=','1')->first()->update(['is_selected'=>0]);
        $menu_category->update(['is_selected'=>1]);
        session()->flash('success','设置成功');
        return redirect()->route('menu_categories.index');
    }
}
