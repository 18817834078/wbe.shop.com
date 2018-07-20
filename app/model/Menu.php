<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=['goods_name','rating','shop_id','category_id','goods_price','description','month_sales',
        'rating_count','tips','satisfy_count','satisfy_rate','goods_img'];

    public function category(){
        return $this->belongsTo('App\model\MenuCategory','category_id','id');
    }
    public function shop(){
        return $this->belongsTo('App\model\Shop','shop_id','id');
    }

}
