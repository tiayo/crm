<?php

namespace Plugins\Manage\Search\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $index;

    public function index()
    {
        return view('manage_search::index', [
            //获取插件配置文件示例
            'plugins_name' => config('manage_search.plugins_name'),
        ]);
    }
}
