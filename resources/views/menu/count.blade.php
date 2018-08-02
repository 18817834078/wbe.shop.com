@extends('default')
@section('content')
        <div class="col-xs-1 container">
            <div>
                <a href="{{route('menus.index')}}"><button type="button" class="btn btn-primary">菜品列表</button></a>
            </div>
            <div><br> </div>
            <div>
                <a href="{{route('menus.count')}}"><button type="button" class="btn btn-primary">菜品统计</button></a>
            </div>
        </div>
    <div class="container-fluid col-xs-11">
        <div class="row">
            <div class="col-xs-4">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th colspan="2" style="text-align: center">今日统计</th>
                    </tr>
                    <tr>
                        <td>菜品</td>
                        <td>销量</td>
                    </tr>
                    @foreach($count_today as $val)
                        <tr>
                            <td>{{$val->goods_name}}</td>
                            <td>{{$val->sum}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-xs-4">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th colspan="2" style="text-align: center">本月统计</th>
                    </tr>
                    <tr>
                        <td>菜品</td>
                        <td>销量</td>
                    </tr>
                    @foreach($count_this_month as $val)
                        <tr>
                            <td>{{$val->goods_name}}</td>
                            <td>{{$val->sum}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-xs-4">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th colspan="2" style="text-align: center">累计销量</th>
                    </tr>
                    <tr>
                        <td>菜品</td>
                        <td>销量</td>
                    </tr>
                    @foreach($count_all as $val)
                        <tr>
                            <td>{{$val->goods_name}}</td>
                            <td>{{$val->sum}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <hr>
        <table class="table table-bordered table-hover">
            <tr>
                <td>查询订单数</td>
                <th>按日查询</th>
                <th>按月查询</th>
            </tr>
            <tr>
                <td>输入日期</td>

                <td>
                    <form  action="{{route('menus.count')}}" method="get">
                        <div class="row">
                            <div class="col-xs-10">
                                <input type="date" class="form-control" name="search_day" value="{{$search_day}}">
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-default">搜索</button>
                            </div>
                        </div>
                    {{--</form>--}}
                </td>
                <td>
                    {{--<form  action="{{route('orders.count')}}" method="get">--}}
                        <div class="row">
                            <div class="col-xs-10">
                                <input type="month" class="form-control" name="search_month" value="{{$search_month}}">
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-default">搜索</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td>统计数目</td>
                <td>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th colspan="2" style="text-align: center">销量</th>
                        </tr>
                        <tr>
                            <td>菜品</td>
                            <td>销量</td>
                        </tr>
                        @foreach($count_day as $val)
                            <tr>
                                <td>{{$val->goods_name}}</td>
                                <td>{{$val->sum}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th colspan="2" style="text-align: center">累计销量</th>
                        </tr>
                        <tr>
                            <td>菜品</td>
                            <td>销量</td>
                        </tr>
                        @foreach($count_month as $val)
                            <tr>
                                <td>{{$val->goods_name}}</td>
                                <td>{{$val->sum}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </div>



@endsection