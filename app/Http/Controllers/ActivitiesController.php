<?php

namespace App\Http\Controllers;

use App\model\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    //展示
    public function index(){
        $activities=Activity::where('end_time','>=',date('Y-m-d',time()));
        if(!file_exists('../resources/views/activity/activities_static.blade.php')){
            $activities_static=view('activity/index',['activities'=>$activities]);
            file_put_contents('../resources/views/activity/activities_static.blade.php',$activities_static);
        }
        return view('activity/activities_static');

    }
    public function show(Activity $activity){
        if (!file_exists('../resources/views/activity/activity_static'.$activity->id.'.blade.php')){
            $activity_static=view('activity/show',['activity'=>$activity]);
            file_put_contents('../resources/views/activity/activity_static'.$activity->id.'.blade.php',$activity_static);
        }

        return view('activity/activity_static'.$activity->id);
    }

}
