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
        //更新、添加、删除操作时经过此中间件验证权限
        $this->middleware('managercontrol')->except(['listView', 'addView']);

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
        $managers = $this->manage->getChildren();

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
        $all_group = $this->manage->getGroup();

        return view('manage.manager.add_or_update', [
            'all_group' => $all_group,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('manager_add'),
            'sign' => 'add',
            'parent_breadcrumb' => 'manager_add',
        ]);
    }

    /**
     * 修改管理员视图
     * 鉴权在控制器中间件进行
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        $all_group = $this->manage->getGroup();

        $old_input = $this->request->session()->has('_old_input') ? session('_old_input') : $this->manage->first($id);

        return view('manage.manager.add_or_update', [
            'all_group' => $all_group,
            'old_input' => $old_input,
            'url' => Route('manager_update', ['id' => $id]),
            'sign' => 'update',
            'parent_breadcrumb' => 'manager_list',
        ]);
    }

    /**
     * 添加/更新提交
     * 鉴权在控制器中间件进行
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required',
            'group' => 'required|integer',
            'password' => 'min:6',
        ]);

        if (empty($id) && $id !== 0) {
            //执行添加操作
            $this->manage->updateOrCreate($this->request->all());
        } else {
            //执行更新操作
            $this->manage->updateOrCreate($this->request->all(), $id);
        }

        return redirect()->route('manager_list');
    }

    /**
     * 删除
     * 鉴权在控制器中间件进行
     *
     * @param $id
     */
    public function destroy($id)
    {
        try {
            $this->manage->destroy($id);
        } catch (\Exception $e) {
            return response('删除失败！');
        }

        return redirect()->route('manager_list');
    }
}