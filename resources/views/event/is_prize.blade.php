@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="/"><button type="button" class="btn btn-primary">返回首页</button></a>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <tr>
                <th>活动名称</th>
                <th>开奖时间</th>
                <th>奖品</th>
                <th>奖品描述</th>
            </tr>
            @foreach($event_prizes as $event_prize)
                <tr>
                    <td>{{$event_prize->event->title}}</td>
                    <td>{{substr($event_prize->event->prize_date,0,16)}}</td>
                    <td>{{$event_prize->name}}</td>
                    <td>{{$event_prize->description}}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection