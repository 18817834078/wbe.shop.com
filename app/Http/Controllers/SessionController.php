<?php

namespace App\Http\Controllers;

use App\model\Shop;
use App\model\ShopCategory;
use App\model\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['reset_password']
        ]);
    }
    //主页
    public function index(){
        return view('home/index');
    }
    //添加
    public function create(){
        $shop_categories=ShopCategory::all()->where('status','=',1);
        return view('home/create',['shop_categories'=>$shop_categories]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50|unique:shop_users,name',
            'email' => 'required|email|unique:shop_users,email',
            'password' => 'required',
            're_password' => 'required',
            'shop_name' => 'required|max:50',
            'start_send' => 'required|numeric',
            'send_cost' => 'required|numeric',
            'shop_img' => 'required',
        ],[
            'name.required'=>'请输入账户名',
            'name.max'=>'账户名字过长',
            'name.unique'=>'已存在账户名',
            'email.required'=>'请输入邮箱',
            'email.email'=>'错误的邮箱格式',
            'email.unique'=>'邮箱已被使用',
            'password.required'=>'请输入密码',
            're_password.required'=>'请再次输入密码',
            'shop_name.required'=>'请输入店铺名',
            'shop_name.max'=>'店铺名过长',
            'start_send.required'=>'请输入起送价',
            'start_send.numeric'=>'起送价必须为数字',
            'send_cost.required'=>'请输入配送费',
            'send_cost.numeric'=>'配送费必须为数字',
            'shop_img.required'=>'请上传一张对应的图片',
        ]);
        if ($request->password!=$request->re_password){
            return back()->withInput()->with('danger','两次密码输入不一致');
        }
        $shop_img=$request->shop_img;
        DB::transaction(function () use ($request,$shop_img) {
            $new_shop = Shop::create([
                'shop_name' => $request->shop_name,
                'brand' => $request->brand ? 1 : 0,
                'on_time' => $request->on_time ? 1 : 0,
                'fengniao' => $request->fengniao ? 1 : 0,
                'bao' => $request->bao ? 1 : 0,
                'piao' => $request->piao ? 1 : 0,
                'zhun' => $request->zhun ? 1 : 0,
                'start_send' => $request->start_send,
                'send_cost' => $request->send_cost,
                'notice' => $request->notice ? $request->notice : '暂无',
                'discount' => $request->discount ? $request->discount : '暂无',
                'shop_rating' => 3,
                'status' => 0,
                'shop_category_id' => $request->shop_category_id,
                'shop_img' => $shop_img,
            ]);
            ShopUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'status' => 1,
                'shop_id' => $new_shop->id,
                'password' => bcrypt($request->password),
            ]);
        });
        session()->flash('success','申请成功,请等待进一步审核');
        return redirect('/index');

    }
    //登入登出
    public function login(){
        return view('/home/login');
    }
    public function login_store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ],[
            'name.required'=>'请输用户名',
            'password.required'=>'请输入密码',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
        $shop_user=ShopUser::where('name','=',$request->name)->first();
        if (!$shop_user){
            return back()->with('danger','用户名或密码错误');
        }
        $shop=Shop::where('id','=',$shop_user->shop_id)->first();
        if ($shop_user->status!=1){
            return back()->with('danger','此账户已被禁用');
        }else{
            if ( $shop->status==0 ){
                return back()->with('danger','此账户下的商店正在审核中');
            }
            if ( $shop->status==-1 ){
                return back()->with('danger','此账户下的商店未通过审核');
            }
        }

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password],$request->remember)) {
            session()->flash('success','登录成功');
            return redirect('/');
        }else{
            return back()->with('danger','用户名或密码错误');
        }


    }
    public function logout(){
        Auth::logout();
        session()->flash('success','登录已注销');
        return redirect('/');

    }
    //修改密码
    public function reset_password(){
        return view('home/reset_password',['shop_user'=>auth()->user()]);
    }
    public function reset_password_store(Request $request){
        $this->validate($request, [
            'new_password' => 'required',
            're_password' => 'required',
            'old_password' => 'required',
            'captcha' => 'required|captcha',
        ],[
            'new_password.required'=>'请输用新的密码',
            're_password.required'=>'请再次输入密码',
            'old_password.required'=>'请输入原来的密码',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
        if ($request->re_password!=$request->new_password){
            return back()->with('danger','两次密码输入须一致');
        }
        if ($request->new_password==$request->old_password){
            return back()->with('danger','新密码不能与旧密码相同');
        }
        if(Hash::check($request->old_password,auth()->user()->password)){
            ShopUser::where('id','=',auth()->user()->id)->update(['password'=>bcrypt($request->new_password)]);
            Auth::logout();
            session()->flash('success','密码修改成功,请重新登录');
            return redirect('/');
        }else{
            return back()->with('danger','原密码不匹配');
        }

    }
}
