@extends('default')
@section('content')
    @include('/error')
    <div>
        <div class="col-xs-3"></div>
        <div class="col-xs-6">
            <form class="form-horizontal" method="post" action="{{route('login_store')}}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">商家账户</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">记住我</label>

                    <div class="col-sm-10">
                        <input type="checkbox"  name="remember">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">验证码</label>
                    <div class="col-sm-10 row">
                        <div class="col-xs-8">
                            <input type="text"  class="form-control" name="captcha">
                        </div>
                        <div class="col-xs-4">
                            <img width="" class="thumbnail captcha" src="{{ captcha_src('default') }}"
                                 onclick="this.src='/captcha/default?'+Math.random()" title="点击图片重新获取验证码">
                        </div>
                    </div>
                </div>

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