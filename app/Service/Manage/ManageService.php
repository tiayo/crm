<?php

namespace App\Service\Manage;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\AdminRepositories;
use Illuminate\Support\Facades\Auth;

class ManageService extends Controller
{
    protected $admin;

    public function __construct(AdminRepositories $admin)
    {
        $this->admin = $admin;
    }

    public function register($data)
    {
        //创建数组
        $admin = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ];

        //创建用户
        $this->admin->create($admin);

        //自动登录
        return Auth::guard('admin')->login($admin);
    }

    public function login()
    {
        $credentials = [
            'name' => 'test1',
            'password' => '123456',
        ];

        if(!Auth::guard('admin')->attempt($credentials)){
            //登录失败
        }

        return redirect()->route('admin');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
    }
}