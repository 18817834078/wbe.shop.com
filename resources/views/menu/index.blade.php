@extends('default')
@section('content')
    <div class="row container-fluid">
        <div class="col-xs-1 container">
            <br><br><br>
            <div>
                <a href="{{route('menus.create')}}"><button type="button" class="btn btn-primary">添加菜品</button></a>
            </div>
            <br>
            <div>
                <a href="{{route('menus.count')}}"><button type="button" class="btn btn-primary">菜品统计</button></a>
            </div>
            <div><br><br> </div>
            @foreach($menu_categories as $menu_category)
                <form action="{{route('menus.index')}}" method="get">
                    <input type="hidden" name="category_id" value="{{$menu_category->id}}">
                    <button type="submit" class="btn btn-block @if($menu_category->id==$category_id) btn-success @endif">{{$menu_category->name}}</button>
                </form>

                <br>
            @endforeach
        </div>

        <div class="col-xs-11 container-fluid">
            <div class="row">

                <div class="col-xs-10">
                    <form class="navbar-form navbar-left" action="{{route('menus.index')}}" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="goods_name" placeholder="菜名" value="{{old('goods_name')}}">
                        </div>
                        <input type="hidden" name="category_id" value={{$category_id}}>
                        &emsp;&emsp;&emsp;&emsp;
                        <div class="form-group">
                            <input type="text" class="form-control" name="price_min" placeholder="0" value="{{old('price_min')}}">
                        </div>
                        -
                        <div class="form-group">
                            <input type="text" class="form-control" name="price_max" placeholder="100" value="{{old('price_max')}}">
                        </div>
                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                </div>
            </div>
            @if($menus->count())
                <div class="container-fluid">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>序号</th>
                            <th>名称</th>
                            <th>评分</th>
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

                {{ $menus->appends([
                'category_id'=>$category_id,
                'goods_name'=>$goods_name,
                'price_min'=>$price_min,
                'price_max'=>$price_max
                ])->links() }}
            @else 您还没有菜品 @endif

        </div>
    </div>


@endsection