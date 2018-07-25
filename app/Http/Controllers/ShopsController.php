<?php

namespace App\Http\Controllers;

use App\model\Shop;
use App\model\ShopCategory;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    //修改
    public function edit(Shop $shop){
        $shop_categories=ShopCategory::all()->where('status','=',1);
        return view('shop/edit',['shop'=>$shop,'shop_categories'=>$shop_categories]);
    }
    public function update(Request $request,Shop $shop){
        $this->validate($request, [
            'shop_name' => 'required|max:50',
            'start_send' => 'required|numeric',
            'send_cost' => 'required|numeric',
        ],[
            'shop_name.required'=>'请输入店铺名',
            'shop_name.max'=>'店铺名过长',
            'start_send.required'=>'请输入起送价',
            'start_send.numeric'=>'起送价必须为数字',
            'send_cost.required'=>'请输入配送费',
            'send_cost.numeric'=>'配送费必须为数字',
        ]);
        $shop_update=[
            'shop_name'=>$request->shop_name,
            'brand'=>$request->brand?1:0,
            'on_time'=>$request->on_time?1:0,
            'fengniao'=>$request->fengniao?1:0,
            'bao'=>$request->bao?1:0,
            'piao'=>$request->piao?1:0,
            'zhun'=>$request->zhun?1:0,
            'start_send'=>$request->start_send,
            'send_cost'=>$request->send_cost,
            'notice'=>$request->notice?$request->notice:'暂无',
            'discount'=>$request->discount?$request->discount:'暂无',
            'shop_category_id'=>$request->shop_category_id,
        ];
        if ($request->shop_img){
            $shop_update['shop_img']=$request->shop_img;
        }
        $shop->update($shop_update);


        session()->flash('success','修改成功');
        return redirect()->route('shop_users.show',[1]);

    }
}
