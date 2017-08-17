<?php

namespace Plugins\Manage\Example\Controllers;

use App\Http\Controllers\Controller;
use Plugins\Manage\Example\Facades\Example;
use Plugins\Manage\Example\Service\IndexService;

class IndexController extends Controller
{
    protected $index;

    /**
     * 这里是依赖注�
     * �案例.
     *
     * IndexController constructor.
     *
     * @param IndexService $index
     */
    public function __construct(IndexService $index)
    {
        $this->index = $index;
    }

    public function index()
    {
        return view('admin_example::index', [
            //获取插件配置文件示例
            'plugins_name' => config('admin_example.plugins_name'),

            //依赖注入执行结果
            'dependency' => $this->index->dependency(),

            //容器注入执行结果
            'app' => app('admin_example_index_service')->app(),

            //facade执行结果
            'facade' => Example::facade(),
        ]);
    }
}
