@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('orders.index')}}"><button type="button" class="btn btn-primary">返回订单</button></a>
    </div>
    <div class="container-fluid">
        <ul class="list-unstyled">
            <li style="font-size: large">订单号:{{$order->sn}}</li>
            <li style="font-size: large">下单时间:{{substr($order->created_at,0,16)}}</li>
            <li style="font-size: large">订单状态:@if($order->status==-1) 已取消 @elseif($order->status==0) 待支付 @elseif($order->status==1) 待发货
                @elseif($order->status==2) 待确认 @else 完成 @endif</li>
            <li style="font-size: large">点餐账号:{{$order->user->username}}</li>
            <li style="font-size: large">收货人:{{$order->name}}</li>
            <li style="font-size: large">联系方式:{{$order->tel}}</li>
            <li style="font-size: large">送货地址:{{$order->province.'-'.$order->city.'-'.
            $order->county.'-'.$order->address}}</li>
            <li style="font-size: large">商品总价:{{$order->total}}</li>
            <li style="font-size: large">商品列表:</li>
            @foreach($order_goods as $order_good)
            &emsp;&emsp;<p>{{$order_good->goods_name}}</p>
            &emsp;&emsp;&emsp;&emsp;商品价格:{{$order_good->goods_price}}<br>
            &emsp;&emsp;&emsp;&emsp;商品数量:{{$order_good->amount}}<br>
            &emsp;&emsp;&emsp;&emsp;商品图片: <img src="{{$order_good->goods_img}}" style="height: 50px" alt="图裂了"><br>
            @endforeach
        </ul>
    </div>
@endsection