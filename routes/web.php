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
Route::resource('menu_categories','MenuCategoriesController');
Route::resource('menus','MenusController');

Route::get('/login','SessionController@login')->name('login');
Route::post('/login_store','SessionController@login_store')->name('login_store');
Route::get('/logout','SessionController@logout')->name('logout');
Route::get('/reset_password','SessionController@reset_password')->name('reset_password');
Route::PATCH('/reset_password_store','SessionController@reset_password_store')->name('reset_password_store');
Route::PATCH('/default/{menu_category}','MenuCategoriesController@default')->name('default');