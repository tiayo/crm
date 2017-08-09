<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\ManagerService;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $manage;
    protected $request;

    public function __construct(ManagerService $manage, Request $request)
    {
        $this->manage = $manage;
        $this->request = $request;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView()
    {
        $managers = $this->manage->get();

        return view('manage.manager.list', [
            'managers' => $managers,
        ]);
    }

    /**
     * 添加管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        $all_group = [];

        return view('manage.manager.add_or_update', [
            'all_group' => $all_group,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('manager_add'),
            'sign' => 'add',
        ]);
    }
}