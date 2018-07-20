@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('menu_categories.create')}}"><button type="button" class="btn btn-primary">添加菜品分类</button></a>
    </div>

    @if($menu_categories->count())
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <tr>
                <th>序号</th>
                <th>分类名</th>
                <th>描述</th>
                <th>是否默认</th>
                <th>操作</th>
            </tr>
             <?php $i=1 ?>
            @foreach($menu_categories as $menu_category)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$menu_category->name}}</td>
                    <td>{{$menu_category->description}}</td>
                    <td> @if($menu_category->is_selected==1) 是 @else 否 @endif </td>

                    <td class="row">
                        <div class="col-xs-2">
                            <a href="{{route('menu_categories.show',[$menu_category])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <a href="{{route('menu_categories.edit',[$menu_category])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
                            </a>
                        </div>
                        <div class="col-xs-2">
                            <form action="{{route('menu_categories.destroy',[$menu_category])}}" method="post">
                                <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                            </form>
                        </div>
                        @if(!$menu_category->is_selected)
                        <div class="col-xs-2">
                            <form action="{{route('default',[$menu_category])}}" method="post">
                                <button type="submit" class="btn btn-warning btn-sm">设为默认</button>
                                {{method_field('PATCH')}}
                                {{csrf_field()}}
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{ $menu_categories->links() }}
    @else 您还没有菜品分类 @endif


@endsection