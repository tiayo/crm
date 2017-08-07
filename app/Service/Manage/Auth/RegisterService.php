<?php

namespace App\Service\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\ManageRepositories;
use Illuminate\Support\Facades\Auth;

class RegisterService extends Controller
{
    protected $manage;

    public function __construct(ManageRepositories $manage)
    {
        $this->manage = $manage;
    }

    public function register($data)
    {
        //创建数组
        $manage = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ];

        //创建用户
        $manage = $this->manage->create($manage);

        //自动登录
        return Auth::guard('manage')->login($manage);
    }
}