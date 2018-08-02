<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EventPrize extends Model
{
    public function shop_user(){
        return $this->belongsTo('App\model\ShopUser','member_id','id');
    }

    public function event(){
        return $this->belongsTo('App\model\Event','events_id','id');
    }
}
