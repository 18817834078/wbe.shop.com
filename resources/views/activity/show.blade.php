@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('activities.index')}}"><button type="button" class="btn btn-primary">返回上一页</button></a>
    </div>
    <br>
    <div class="container-fluid">

        {!!$activity->content!!}
    </div>
@endsection