<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        // 验证: 验证失败会直接return
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        // 存储
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>bcrypt($request->password),
        ]);
        
        // 注册后，自动登录
        Auth::login($user);
        // 将注册成功提示存入闪存
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    // 编辑资料页面
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // 更新资料操作
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功');

        return redirect()->route('users.show', $user->id);
    }
}
