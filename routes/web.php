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

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup');

// Route::resource('users', 'UsersController');

// 隐性路由模型绑定的好处：
// get 匹配 userId，内部会多做一个操作，根据 id 获取对应模型 User，然后将 User 传递给 UsersController下的show
// 开启条件：
// 1. 传参变量必须是模型单数形式
// 2. 控制器方法里要显式声明模型类型 public function show(User $user) {}
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
