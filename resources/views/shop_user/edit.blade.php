@extends('default')
@section('content')
    @include('/error')
    <div>
        <div class="col-xs-3"></div>
        <div class="col-xs-6">
            <form class="form-horizontal" method="post" action="{{route('shop_users.update',[$shop_user])}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">商家账户</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"  name="name" value="{{$shop_user->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">商家邮箱</label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="email" value="{{$shop_user->email}}">
                    </div>
                </div>

                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection