<?php
/**
 * 当前用户是否有权限操作指定分组中间件.
 */

namespace App\Http\Middleware;

use App\Services\Manage\ManagerGroupService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ManagerGroupControl
{
    protected $manager;
    protected $manager_group;
    protected $request;

    public function __construct(ManagerControl $manager, ManagerGroupService $manager_group, Request $request)
    {
        $this->manager = $manager;
        $this->manager_group = $manager_group;
        $this->request = $request;
    }

    public function handle($request, Closure $next)
    {
        //获取当前路由名称
        $currentRouteName = $this->manager->handleRouteName(Route::currentRouteAction());

        //判断验证结果
        if (method_exists($this, $currentRouteName) && $this->$currentRouteName()) {
            return $next($request);
        }

        $response = $request->session()->has('middleware.errors') ? session('middleware.errors') : '您没有权限！';

        return response($response, 403);
    }

    /**
     * 验证updateView方法.
     *
     * @param $id
     *
     * @return bool
     */
    public function updateView()
    {
        $id = $this->request->route('id');

        $group = Auth::guard('manager')->user()['group'];

        //不允许修改自己所属的分组
        if ($group == $id) {
            return false;
        }

        return $this->manager->group($id);
    }

    /**
     * 验证post方法.
     *
     * @param $id
     * @param $group
     *
     * @return bool
     */
    public function post()
    {
        $id = $this->request->route('id');

        $group = $this->request->get('group');

        //添加时验证方法
        if (empty($id)) {
            if ($this->manager->group($group)) {
                return $this->sidebar();
            }

            return false;
        }

        //更新时验证方法
        return $this->updateView();
    }

    /**
     * 验证destroy方法.
     *
     * @param $id
     * @param $group
     *
     * @return bool
     */
    public function destroy()
    {
        $id = $this->request->route('id');

        //不能非空分组
        if (!empty($this->manager_group->first($id))) {
            echo '分组下存在管理员，请先移除！';
            http_response_code(403);
            exit();
        }

        //验证其他
        return $this->updateView();
    }

    /**
     * 验证添加的菜单是否被�
     * �许.
     *
     * @param $group
     *
     * @return bool
     */
    public function sidebar()
    {
        $selects = $this->request->get('rule');

        $sidebars = $this->manager_group->first(Auth::guard('manager')->user()['group'])['rule'];

        foreach ($sidebars as $sidebar) {
            foreach ($selects as $key => $select) {
                if ($sidebar == $select) {
                    unset($selects[$key]);
                }
            }

            //全部被匹配，返回true
            if (empty($selects)) {
                return true;
            }
        }

        return false;
    }
}
