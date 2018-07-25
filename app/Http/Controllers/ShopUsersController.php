<?php

namespace App\Http\Controllers;

use App\model\Shop;
use App\model\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
    //修改
    protected function edit(){
        return view('shop_user/edit',['shop_user'=>auth()->user()]);
    }
    protected function update(Request $request,ShopUser $shop_user){
        $this->validate($request, [
            'name'=>['required','max:50',Rule::unique('shop_users')->ignore($shop_user->id)],
            'email'=>['required','email',Rule::unique('shop_users')->ignore($shop_user->id)]

        ],[
            'name.required'=>'请输入账户名',
            'name.max'=>'账户名字过长',
            'name.unique'=>'已存在的账户名',
            'email.required'=>'请输入邮箱',
            'email.email'=>'错误的邮箱格式',
            'email.unique'=>'邮箱已被使用',
        ]);
        $shop_user->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        Auth::logout();
        session()->flash('success','修改成功,请重新登录');
        return redirect()->route('login');
    }
}
