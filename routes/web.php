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


/**
 * 注册
 */

// Route::resource('users', 'UsersController');

// 隐性路由模型绑定的好处：
// get 匹配 userId，内部会多做一个操作，根据 id 获取对应模型 User，然后将 User 传递给 UsersController下的show
// 开启条件：
// 1. 传参变量必须是模型单数形式
// 2. 控制器方法里要显式声明模型类型 public function show(User $user) {}
Route::get('/users/{user}', 'UsersController@show')->name('users.show'); # 显示个人信息

Route::post('/users', 'UsersController@store')->name('users.store'); # 注册


/**
 * 登录、退出
 */
Route::get('login', 'SessionsController@create')->name('login');  # 登录页
Route::post('login', 'SessionsController@store')->name('login');  # 登录操作
Route::delete('logout', 'SessionsController@destroy')->name('logout');  # 退出操作


/**
 * 编辑用户
 */
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit'); # 编辑用户表单页
Route::patch('/users/{user}', 'UsersController@update')->name('users.update'); # 更新操作

Route::get('/users', 'UsersController@index')->name('users.index'); # 用户列表页面

Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy'); # 删除用户操作

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request'); # 显示重置密码的邮箱发送页面
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email'); # 邮箱发送重设链接
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset'); # 密码更新页面
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update'); # 执行密码更新操作

Route::resource('statuses', 'StatusesController', ['only'=>['store', 'destroy']]);
