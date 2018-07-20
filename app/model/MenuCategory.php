<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable=['name','type_accumulation','shop_id','description','is_selected'];

    public function shop(){
        return $this->belongsTo('App\model\Shop','shop_id','id');
    }
}
