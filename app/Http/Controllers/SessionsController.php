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
         */
        if (Auth::attempt($credentials))
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
}
