<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','SessionController@index');
Route::get('/index','SessionController@index');
Route::get('/create','SessionController@create');
Route::post('/store','SessionController@store');

Route::resource('shop_users','ShopUsersController');
Route::resource('shops','ShopsController');
Route::resource('menu_categories','MenuCategoriesController');
Route::resource('menus','MenusController');
Route::resource('activities','ActivitiesController');
Route::resource('orders','OrdersController');
Route::resource('events','EventsController');
Route::get('show_prize/{event}','EventsController@show_prize')->name('show_prize');
Route::get('join_event/{event}','EventsController@join_event')->name('join_event');
Route::get('is_prize','EventsController@is_prize')->name('is_prize');

Route::get('orders.send/{order}','OrdersController@send')->name('orders.send');
Route::get('orders.giveup/{order}','OrdersController@giveup')->name('orders.giveup');
Route::get('orders.count','OrdersController@count')->name('orders.count');
Route::get('menus.count','MenusController@count')->name('menus.count');
Route::get('/login','SessionController@login')->name('login');
Route::post('/login_store','SessionController@login_store')->name('login_store');
Route::get('/logout','SessionController@logout')->name('logout');
Route::get('/reset_password','SessionController@reset_password')->name('reset_password');
Route::PATCH('/reset_password_store','SessionController@reset_password_store')->name('reset_password_store');
Route::PATCH('/default/{menu_category}','MenuCategoriesController@default')->name('default');

//图片上传
Route::post('web_upload_goods',function (){
    $storage=\Illuminate\Support\Facades\Storage::disk('oss');
    $file_name=$storage->putFile('/goods',request()->file('file'));
    return ['file_name'=>$storage->url($file_name)];
})->name('web_upload_goods');
Route::post('web_upload_shop',function (){
    $storage=\Illuminate\Support\Facades\Storage::disk('oss');
    $file_name=$storage->putFile('/shop',request()->file('file'));
    return ['file_name'=>$storage->url($file_name)];
})->name('web_upload_shop');