<?php

namespace App\Http\Controllers;

use App\model\Order;
use App\model\OrderGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    //展示
    public function index(){
//        echo auth()->user()->shop->id;die;
        $orders=Order::where('shop_id','=',auth()->user()->shop->id)->paginate(5);
        return view('order/index',['orders'=>$orders]);
    }
    public function show(Order $order){
        $order_goods=OrderGood::where('order_id','=',$order->id)->get();
        return view('order/show',['order'=>$order,'order_goods'=>$order_goods]);
    }
    //取消订单
    public function giveup(Order $order){
        $order->update([
            'status'=>-1
        ]);
        return redirect()->route('orders.index');
    }
    //发货
    public function send(Order $order){
        $order->update([
            'status'=>2
        ]);
        return redirect()->route('orders.index');
    }
    //统计订单
    public function count(Request $request){
        $orders_all=Order::where('shop_id','=',auth()->user()->shop->id)->get();
        $count_all=0;
        $count_today=0;
        $count_this_month=0;
        $count_day=0;
        $count_month=0;
        foreach ($orders_all as $order){
            $count_all++;
            if (substr($order->created_at,0,7)==date('Y-m',time())){
                $count_this_month++;
                if (substr($order->created_at,0,10)==date('Y-m-d',time())){
                    $count_today++;
                }
            }
            if ($request->search_day){
                if (substr($order->created_at,0,10)==$request->search_day){
                    $count_day++;
                }
            }
            if ($request->search_month){
                if (substr($order->created_at,0,7)==$request->search_month){
                    $count_month++;
                }
            }


        }
        return view('order/count',[
            'count_today'=>$count_today,
            'count_this_month'=>$count_this_month,
            'count_all'=>$count_all,
            'count_day'=>$count_day,
            'count_month'=>$count_month,
            'search_month'=>$request->search_month,
            'search_day'=>$request->search_day,
        ]);
    }
}
