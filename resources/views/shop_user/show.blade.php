@extends('default')
@section('content')
    <div class="container-fluid row">
        <div class="col-xs-2">
            <a href="/"><button type="button" class="btn btn-primary">返回主页</button></a>
        </div>
    </div>
    <div class="container-fluid">
        <ul class="list-unstyled">

            <li style="font-size: large">账号名:{{$shop_user->name}}</li>
            <li style="font-size: large">商家邮箱:{{$shop_user->email}}</li>
            <li style="font-size: large">商家状态:@if($shop_user->status) 已启用 @else 已禁用 @endif</li>

            <hr>
            <li style="font-size: large">下属店铺:{{$shop->shop_name}}</li>
            <li style="font-size: large">店铺评分:{{$shop->shop_rating}}星</li>
            <li style="font-size: large">起送金额:{{$shop->start_send}}元</li>
            <li style="font-size: large">配送费:{{$shop->send_cost}}元</li>
            <li style="font-size: large">店公告:{{$shop->notice}}</li>
            <li style="font-size: large">优惠信息:{{$shop->discount}}</li>
            <li style="font-size: large">是否品牌: <span class="@if($shop->brand==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">准时送达: <span class="@if($shop->on_time==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">蜂鸟配送: <span class="@if($shop->fengniao==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">保标记: <span class="@if($shop->bao==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">票标记: <span class="@if($shop->piao==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">准标记: <span class="@if($shop->zhun==true) glyphicon glyphicon-ok @else glyphicon glyphicon-remove @endif"></span> </li>
            <li style="font-size: large">店铺图片: <img height="50" src="{{$shop->shop_img}}" alt="店铺图片"> </li>
            <li style="font-size: large">店状态:@if($shop->status==1) 正常 @elseif($shop->status==0) 审核中 @else 禁用 @endif</li>



        </ul>
    </div>
@endsection