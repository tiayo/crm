<?php

namespace App\Service\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepositories;
use Illuminate\Support\Facades\Auth;

class RegisterService extends Controller
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
        $admin = $this->admin->create($admin);

        //自动登录
        return Auth::guard('admin')->login($admin);
    }
}