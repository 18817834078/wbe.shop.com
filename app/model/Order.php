<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        'user_id','shop_id','sn','province','city','county','address','tel','name','total','status','created_at','out_trade_no'
    ];

    public function shop(){
        return $this->belongsTo('App\model\shop','shop_id','id');
    }

    public function user(){
        return $this->belongsTo('App\model\User','user_id','id');
    }
}
