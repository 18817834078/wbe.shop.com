@extends('default')
@section('content')
    <div class="container-fluid">
        <a href="{{route('is_prize')}}"><button type="button" class="btn btn-primary">我的中奖纪录</button></a>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <tr>
                <th>活动名称</th>
                <th>报名开始时间</th>
                <th>报名结束时间</th>
                <th>开奖时间</th>
                <th>报名人数限制</th>
                <th>是否已开奖</th>
                <th>操作</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td>{{$event->title}}</td>
                    <td>{{date('Y-m-d H:i',$event->signup_start)}}</td>
                    <td>{{date('Y-m-d H:i',$event->signup_end)}}</td>
                    <td>{{substr($event->prize_date,0,16)}}</td>
                    <td>{{$event->signup_num}}</td>
                    <td>@if($event->is_prize) 已开奖 @else 未开奖 @endif</td>
                    <td class="row">
                        <div class="col-xs-2">
                            <a href="{{route('events.show',[$event])}}">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-zoom-in"></span></button>
                            </a>
                        </div>

                        <div class="col-xs-2">
                            <a href="{{route('show_prize',['event'=>$event])}}">
                                <button type="submit" class="btn  btn-sm">奖品</button>
                            </a>
                        </div>
                        @if($event->signup_end<time())
                            <div class="col-xs-2">
                                <button type="submit" class="btn  btn-sm">已截止</button>
                            </div>
                        @elseif(\App\model\EventMember::where([['events_id','=',$event->id],['member_id','=',auth()->user()->id]])->first())
                            <div class="col-xs-2">
                                <button type="submit" class="btn  btn-sm">已报名</button>
                            </div>
                        @else
                        <div class="col-xs-2">
                            <a href="{{route('join_event',['event'=>$event])}}">
                                <button type="submit" class="btn  btn-sm">我要报名</button>
                            </a>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

{{ $events->links() }}
@endsection