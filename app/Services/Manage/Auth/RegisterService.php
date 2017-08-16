<?php

namespace App\Services\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\ManageRepository;
use Illuminate\Support\Facades\Auth;

class RegisterService extends Controller
{
    protected $manage;

    public function __construct(ManageRepository $manage)
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
        return Auth::guard('manager')->login($manage);
    }
}