@extends('default')
@section('content')

    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <tr>
                <th>奖品</th>
                <th>描述</th>
            </tr>
            @foreach($event_prizes as $event_prize)
                <tr>
                    <td>{{$event_prize->name}}</td>
                    <td>{{$event_prize->description}}</td>

                </tr>
            @endforeach
        </table>
    </div>

@endsection