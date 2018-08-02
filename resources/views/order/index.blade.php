@extends('default')
@section('content')
    @if($orders->count())
        <div class="col-xs-1 container">
            <div>
                <a href="{{route('orders.index')}}"><button type="button" class="btn btn-primary">订单列表</button></a>
            </div>
            <div><br> </div>
            <div>
                <a href="{{route('orders.count')}}"><button type="button" class="btn btn-primary">订单统计</button></a>
            </div>
        </div>
    <div class="container-fluid col-xs-11">
        <table class="table table-bordered table-hover">
            <tr>
                <th>订单号</th>
                <th>收货人</th>
                <th>联系方式</th>
                <th>订单总价</th>
                <th>订单状态</th>
                <th>操作</th>
            </tr>
             <?php $i=1 ?>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->sn}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->tel}}</td>
                    <td>{{$order->total}}</td>
                    <td>@if($order->status==-1) 已取消 @elseif($order->status==0) 待支付 @elseif($order->status==1) 待发货
                        @elseif($order->status==2) 待确认 @else 完成 @endif</td>
                    <td class="row">
                        <div class="col-xs-2">
                            <a href="{{route('orders.show',[$order])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>
                            </a>
                        </div>
                        @if($order->status==0||$order->status==1)
                        <div class="col-xs-2">
                            <a href="{{route('orders.send',[$order])}}">
                                <button type="submit" class="btn btn-primary btn-sm">发货</button>
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <a href="{{route('orders.giveup',[$order])}}">
                                <button type="submit" class="btn btn-primary btn-sm">取消订单</button>
                            </a>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{ $orders->links() }}
    @else 您还没有订单 @endif


@endsection