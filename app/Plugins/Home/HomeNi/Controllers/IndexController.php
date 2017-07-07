<?php

namespace Plugins\Home\HomeNi\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $index;

    public function index()
    {
        return view('home_homeni::index', [
            //获取插件配置文件示例
            'plugins_name' => config('home_homeni.plugins_name'),
        ]);
    }
}