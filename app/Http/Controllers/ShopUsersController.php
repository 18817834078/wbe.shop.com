<?php

namespace App\Http\Controllers;

use App\model\Shop;
use Illuminate\Http\Request;

class ShopUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }
    //展示
    public function index(){

    }
    public function show(){
        $shop=Shop::where('id','=',auth()->user()->shop_id)->first();
        return view('shop_user/show',['shop_user'=>auth()->user(),'shop'=>$shop]);
    }
}
