@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('menus.create')}}"><button type="button" class="btn btn-primary">添加菜品</button></a>
    </div>

    @if($menus->count())
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>评分</th>
                <th>所属商家</th>
                <th>所属分类</th>
                <th>价格</th>
                <th>月销量</th>
                <th>图片</th>
                <th>操作</th>
            </tr>
             <?php $i=1 ?>
            @foreach($menus as $menu)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$menu->goods_name}}</td>
                    <td>{{$menu->rating}}星</td>
                    <td>{{$menu->shop->shop_name}}</td>
                    <td>{{$menu->category->name}}</td>
                    <td>{{$menu->goods_price}}</td>
                    <td>{{$menu->month_sales}}</td>
                    <td><img height="50" src="{{$menu->goods_img}}" alt="菜品图片"></td>

                    <td class="row">
                        <div class="col-xs-2">
                            <a href="{{route('menus.show',[$menu])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <a href="{{route('menus.edit',[$menu])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <form action="{{route('menus.destroy',[$menu])}}" method="post">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{ $menus->links() }}
    @else 您还没有菜品 @endif


@endsection