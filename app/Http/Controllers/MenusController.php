<?php

namespace App\Http\Controllers;

use App\model\Menu;
use App\model\MenuCategory;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    //展示
    public function index(){
        $menus=Menu::where('shop_id','=',auth()->user()->shop_id)->paginate(5);
        return view('menu/index',['menus'=>$menus]);
    }
    public function show(Menu $menu){
        return view('menu/show',['menu'=>$menu]);
    }
    //添加
    public function create(){
        $menu_categories=MenuCategory::all()->where('shop_id','=',auth()->user()->shop_id);
        return view('menu/create',['menu_categories'=>$menu_categories]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'goods_name' => 'required|max:50',
            'goods_price' => 'required|numeric',
            'goods_img' => 'required',
        ], [
            'goods_name.required' => '请输入菜品名字',
            'goods_name.max' => '菜品名字过长',
            'goods_price.required' => '菜品价格必须填写',
            'goods_price.numeric' => '菜品价格必须为数字',
            'goods_img.required' => '须上传一张商品商品',
        ]);
        if (!$request->description){$request->description='暂无';}
        if (!$request->tips){$request->tips='暂无';}
        $goods_img=$request->goods_img->store('public/menu');
        $goods_img=\Illuminate\Support\Facades\Storage::url($goods_img);
        Menu::create([
            'goods_name'=>$request->goods_name,
            'rating'=>0,
            'shop_id'=>auth()->user()->shop_id,
            'category_id'=>$request->category_id,
            'goods_price'=>$request->goods_price,
            'description'=>$request->description,
            'month_sales'=>0,
            'rating_count'=>0,
            'tips'=>$request->tips,
            'satisfy_count'=>0,
            'satisfy_rate'=>0,
            'goods_img'=>url($goods_img),

        ]);
        session()->flash('success','添加成功');
        return redirect()->route('menus.index');


    }
    //删除
    public function destroy(Menu $menu){
        $menu->delete();
        session()->flash('success','删除成功');
        return redirect()->route('menus.index');
    }
    //修改
    public function edit(Menu $menu){
        $menu_categories=MenuCategory::all()->where('shop_id','=',auth()->user()->shop_id);
        return view('menu/edit',['menu'=>$menu,'menu_categories'=>$menu_categories]);
    }
    public function update(Request $request,Menu $menu){
        $this->validate($request, [
            'goods_name' => 'required|max:50',
            'goods_price' => 'required|numeric',
            'goods_img' => 'required',
        ], [
            'goods_name.required' => '请输入菜品名字',
            'goods_name.max' => '菜品名字过长',
            'goods_price.required' => '菜品价格必须填写',
            'goods_price.numeric' => '菜品价格必须为数字',
            'goods_img.required' => '须上传一张商品商品',
        ]);
        if (!$request->description){$request->description='暂无';}
        if (!$request->tips){$request->tips='暂无';}
        $goods_img=$request->goods_img->store('public/menu');
        $goods_img=\Illuminate\Support\Facades\Storage::url($goods_img);
        $menu->update([
            'goods_name'=>$request->goods_name,
            'goods_price'=>$request->goods_price,
            'category_id'=>$request->category_id,
            'description'=>$request->description,
            'tips'=>$request->tips,
            'goods_img'=>url($goods_img),
        ]);
        session()->flash('success','修改成功');
        return redirect()->route('menus.index');
    }
}
