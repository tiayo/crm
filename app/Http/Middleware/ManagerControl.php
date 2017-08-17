<?php
/**
 * 当前用户是否有权限操作指定管理员中间件.
 */

namespace App\Http\Middleware;

use App\Services\Manage\ManagerGroupService;
use App\Services\Manage\ManagerService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ManagerControl
{
    protected $manager;
    protected $manager_group;

    public function __construct(ManagerService $manager, ManagerGroupService $manager_group)
    {
        $this->manager = $manager;
        $this->manager_group = $manager_group;
    }

    public function handle(Request $request, Closure $next)
    {
        //获取当前路由名称
        $currentRouteName = $this->handleRouteName(Route::currentRouteAction());

        //判断验证结果
        if (method_exists($this, $currentRouteName) && $this->$currentRouteName($request->route('id'), $request->get('group'))) {
            return $next($request);
        }

        return response('您没有权限！', 403);
    }

    /**
     * 验证updateView方法.
     *
     * @param $id
     *
     * @return bool
     */
    public function updateView($id, $group)
    {
        $manager_children = $this->manager->getChildren();

        foreach ($manager_children as $children) {
            if ($children['id'] == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * 验证post方法.
     *
     * @param $id
     * @param $group
     *
     * @return bool
     */
    public function post($id, $group)
    {
        if (empty($id)) {
            return $this->group($group);
        }

        if ($this->updateView($id, $group)) {
            return $this->group($group);
        }

        return false;
    }

    /**
     * 验证destroy方法.
     *
     * @param $id
     * @param $group
     *
     * @return bool
     */
    public function destroy($id, $group)
    {
        //不能删除自己
        if ($id == Auth::guard('manager_id')->id()) {
            return false;
        }

        //验证其他
        return $this->updateView($id, $group);
    }

    /**
     * 验证添加.
     *
     * @param $group
     *
     * @return bool
     */
    public function group($group)
    {
        $manager_children_group = $this->manager_group
            ->getChildrenGroup(Auth::guard('manager')->user()['group'], 'managergroup_id');

        foreach ($manager_children_group as $children) {
            if ($children['managergroup_id'] == $group) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取来访方法名.
     *
     * @param $route_name
     *
     * @return null|string
     */
    public function handleRouteName($route_name)
    {
        $array = explode('@', $route_name);

        return end($array);
    }
}
