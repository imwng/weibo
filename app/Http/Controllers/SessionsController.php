<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        /**
         * Auth::attempt
         * 1. 验证
         * 2. 成功 -> 创建会话 & 种下一个 laravel_session & true
         * 3. 失败 -> false
         * 4. 添加 remember 后，多种下一个remember_web，当 laravel_session 2个小时后过期时，会判断有没有 remember 这个session，有就更新 laravel_session，没有就退出账号
         */
        if (Auth::attempt($credentials, $request->has('remember')))
        {
            // 登录成功
            session()->flash('success', '欢迎回来~');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登录失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出~');
        return redirect('login');
    }
}
