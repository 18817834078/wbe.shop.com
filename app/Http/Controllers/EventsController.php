<?php

namespace App\Http\Controllers;

use App\model\Event;
use App\model\EventMember;
use App\model\EventPrize;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    //展示
    public function index(){
        $events=Event::paginate(5);
        return view('event/index',['events'=>$events]);
    }
    public function show(Event $event){
        return view('event/show',['event'=>$event]);
    }
    public function show_prize(Request $request){
        $event=$request->event;
        $event_prizes=EventPrize::where('events_id','=',$event)->get();
        return view('event/show_prize',['event_prizes'=>$event_prizes]);
    }
    //报名
    public function join_event(Request $request){

        $signup_num=Event::select('signup_num')->where('id',$request->event)->first()->signup_num;
        $now_num=EventMember::where('events_id',$request->event)->count();
        if ($now_num>=$signup_num){
            return redirect()->route('events.index')->with('danger','报名人数已满');
        }

        EventMember::create([
            'events_id'=>$request->event,
            'member_id'=>auth()->user()->id
        ]);
        return redirect()->route('events.index')->with('success','报名成功');
    }
    //查询中奖
    public function is_prize(){
        $event_prizes=EventPrize::where('member_id',auth()->user()->id)->get();
        return view('event/is_prize',['event_prizes'=>$event_prizes]);
    }

}
