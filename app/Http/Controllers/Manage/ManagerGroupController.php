<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Admin\SidebarService;
use App\Services\Manage\ManagerGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerGroupController extends Controller
{
    protected $manager_group;
    protected $request;
    protected $sidebar;

    public function __construct(ManagerGroupService $manager_group, Request $request, SidebarService $sidebar)
    {
        $this->manager_group = $manager_group;
        $this->request = $request;
        $this->sidebar = $sidebar;
    }

    /**
     * 列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView()
    {
        return view('manage.managergroup.list', [
            'all_group' => $this->manager_group->get(),
        ]);
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        $all_sidebar = $this->sidebar->tree($this->sidebar->all());

        $all_group = $this->manager_group->getChildrenGroup(Auth::guard('manager')->user()['group']);

        return view('manage.managergroup.add_or_update', [
            'all_sidebar' => $all_sidebar,
            'all_group' => $all_group,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('managergroup_add'),
            'sign' => 'add',
            'parent_breadcrumb' => 'managergroup_list',
        ]);
    }

    /**
     * 更新视图
     *
     * @param $id [分组id]
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        $all_sidebar = $this->sidebar->tree($this->sidebar->all());

        $all_group = $this->manager_group->get();

        $old_input = $this->request->session()->has('_old_input') ? session('_old_input') : $this->manager_group->first($id);

        return view('manage.managergroup.add_or_update', [
            'all_sidebar' => $all_sidebar,
            'all_group' => $all_group,
            'old_input' => $old_input,
            'url' => Route('managergroup_update', ['id' => $id]),
            'sign' => 'update',
            'parent_breadcrumb' => 'managergroup_list',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'rule' => 'required|array',
            'rule.*' => 'required|integer',
        ]);

        if (empty($id) && $id !== 0) {
            //执行添加操作
            $this->manager_group->updateOrCreate($this->request->all());
        } else {
            //执行更新操作
            $this->manager_group->updateOrCreate($this->request->all(), $id);
        }

        return redirect()->route('managergroup_list');
    }


}