@extends('default')
@section('content')
    @include('/error')
    <div>
        <div class="col-xs-3"></div>
        <div class="col-xs-6">
            <form class="form-horizontal" method="post" action="{{route('menus.update',[$menu])}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">菜品名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="goods_name" value="{{$menu->goods_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">价格</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="goods_price" value="{{$menu->goods_price}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description">{{$menu->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">提示信息</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="tips">{{$menu->tips}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">菜品分类</label>
                    <div class="col-sm-10">
                        <select  class="form-control" name="category_id">
                            @foreach($menu_categories as $menu_category)
                            <option @if($menu_category->id==$menu->category_id) selected @endif value="{{$menu_category->id}}">{{$menu_category->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-2 control-label">
                        <label for="inputEmail3" class="avatar-label">菜品图片</label>
                    </div>
                    <div class="col-xs-5">
                        <input type="file" name="goods_img">
                    </div>
                </div>
                {{method_field('PATCH')}}
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection