<?php

namespace App\Http\Controllers;

use App\model\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    //展示
    public function index(){
        $activities=Activity::where('end_time','>=',date('Y-m-d',time()))->paginate(5);
        return view('activity/index',['activities'=>$activities]);
    }
    public function show(Activity $activity){
        return view('activity/show',['activity'=>$activity]);
    }

}
