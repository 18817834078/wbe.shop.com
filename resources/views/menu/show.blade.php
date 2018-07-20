@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('menus.create')}}"><button type="button" class="btn btn-primary">添加菜品</button></a>
    </div>
    <div class="container-fluid">
        <ul class="list-unstyled">
            <li style="font-size: large">名称:{{$menu->goods_name}}</li>
            <li style="font-size: large">评分:{{$menu->rating}}星</li>
            <li style="font-size: large">所属商家:{{$menu->shop->shop_name}}</li>
            <li style="font-size: large">所属分类:{{$menu->category->name}}</li>
            <li style="font-size: large">价格:{{$menu->goods_price}}元</li>
            <li style="font-size: large">描述:{{$menu->description}}</li>
            <li style="font-size: large">月销量:{{$menu->month_sales}}笔</li>
            <li style="font-size: large">评分数量:{{$menu->rating_count}}个</li>
            <li style="font-size: large">提示信息:{{$menu->tips}}</li>
            <li style="font-size: large">满意度数量:{{$menu->satisfy_count}}个</li>
            <li style="font-size: large">满意度评分:{{$menu->satisfy_rate}}星</li>
            <li style="font-size: large">菜品图片: <img height="50" src="{{$menu->goods_img}}" alt="菜品图片"></li>
        </ul>
    </div>
@endsection