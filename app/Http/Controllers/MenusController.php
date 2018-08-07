<?php

namespace App\Http\Controllers;

use App\model\Menu;
use App\model\MenuCategory;
use App\model\OrderGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MenusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    //展示
    public function index(Request $request){
        $menu_categories=MenuCategory::all()->where('shop_id','=',auth()->user()->shop_id);
        $where=[
            ['shop_id','=',auth()->user()->shop_id]
        ];
        if ($request->category_id){$where[]=['category_id','=',$request->category_id];}
        $search_id=[];
        if ($request->goods_name){
//            $where[]=['goods_name','like','%'.$request->goods_name.'%'];
            //汉字分词搜索
            $cl = new \App\SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
            $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
            $cl->SetLimits(0, 1000);
            $info = $request->goods_name;
            $res = $cl->Query($info, 'menus');//shopstore_search
//print_r($cl);
            if (isset($res['matches'])){
                foreach ($res['matches'] as $val){
                    $search_id[]=$val['id'];
                }
            }

//            $search_id=substr($search_id,0,-1);
//            $where[]=['id','in',$search_id];
        }
        if ($request->price_min){$where[]=['goods_price','>=',$request->price_min];}
        if ($request->price_max){$where[]=['goods_price','<=',$request->price_max];}

        if (!$request->goods_name){
            $menus=Menu::where($where)->paginate(5);
        }else{
            $menus=Menu::where($where)->whereIn('id',$search_id)->paginate(5);
        }


        return view('menu/index',['menus'=>$menus,
            'menu_categories'=>$menu_categories,
            'category_id'=>$request->category_id,
            'goods_name'=>$request->goods_name,
            'price_min'=>$request->price_min,
            'price_max'=>$request->price_max,
        ]);
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
        $goods_img=$request->goods_img;
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
            'goods_img'=>$goods_img,

        ]);
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }

        session()->flash('success','添加成功');
        return redirect()->route('menus.index');


    }
    //删除
    public function destroy(Menu $menu){
        $menu->delete();
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }

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
        ], [
            'goods_name.required' => '请输入菜品名字',
            'goods_name.max' => '菜品名字过长',
            'goods_price.required' => '菜品价格必须填写',
            'goods_price.numeric' => '菜品价格必须为数字',
        ]);
        if (!$request->description){$request->description='暂无';}
        if (!$request->tips){$request->tips='暂无';}
        $update=[
            'goods_name'=>$request->goods_name,
            'goods_price'=>$request->goods_price,
            'category_id'=>$request->category_id,
            'description'=>$request->description,
            'tips'=>$request->tips,
        ];
        if ($request->goods_img){$update['goods_img']=$request->goods_img;}
        $menu->update($update);
        //redis修改
        if (Redis::get('shops_json')){
            Redis::del('shops_json');
        }
        if (Redis::get('shop_json'.auth()->user()->shop_id)){
            Redis::del('shop_json'.auth()->user()->shop_id);
        }

        session()->flash('success','修改成功');
        return redirect()->route('menus.index');
    }
    //统计
    public function count(Request $request){
        $shop_id=auth()->user()->shop->id;
        $today=date('Y-m-d',time());
        $this_month=date('Y-m',time());
        $count_today=DB::select("select goods_name,SUM(amount) as sum 
from order_goods 
where goods_id IN (select id from menus where shop_id={$shop_id}) and created_at LIKE '{$today}%' 
group by goods_id order by sum desc");
        $count_this_month=DB::select("select goods_name,SUM(amount) as sum 
from order_goods 
where goods_id IN (select id from menus where shop_id={$shop_id}) and created_at LIKE '{$this_month}%' 
group by goods_id order by sum desc");
        $count_all=DB::select("select goods_name,SUM(amount) as sum 
from order_goods 
where goods_id IN (select id from menus where shop_id={$shop_id})  
group by goods_id order by sum desc");
        $count_day=[];$count_month=[];
        if ($request->search_day){
            $day=$request->search_day;
            $count_day=DB::select("select goods_name,SUM(amount) as sum 
from order_goods 
where goods_id IN (select id from menus where shop_id={$shop_id}) and created_at LIKE '{$day}%' 
group by goods_id order by sum desc");
        }
        if ($request->search_month){
            $month=$request->search_month;
            $count_month=DB::select("select goods_name,SUM(amount) as sum 
from order_goods 
where goods_id IN (select id from menus where shop_id={$shop_id}) and created_at LIKE '{$month}%' 
group by goods_id order by sum desc");
        }

        return view('menu/count',[
            'count_today'=>$count_today,
            'count_this_month'=>$count_this_month,
            'count_all'=>$count_all,
            'count_day'=>$count_day,
            'count_month'=>$count_month,
            'search_day'=>$request->search_day,
            'search_month'=>$request->search_month,

        ]);
    }
}
