<?php

namespace Plugins\Admin\Wxample\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $index;

    public function index()
    {
        return view('admin_wxample::index', [
            //获取插件配置文件示例
            'plugins_name' => config('admin_wxample.plugins_name'),
        ]);
    }
}