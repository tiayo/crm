<?php

namespace Plugins\User\TestUser\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $index;

    public function index()
    {
        return view('user_testuser::index', [
            //获取插件配置文件示例
            'plugins_name' => config('user_testuser.plugins_name'),
        ]);
    }
}