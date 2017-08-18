<?php

namespace App\Http\Middleware;

use App\Model\Manager;
use App\Repositories\SidebarRepository;
use App\Services\Manage\ManagerGroupService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ManageAuth
{
    protected $sidebar;
    protected $manage_group;

    public function __construct(SidebarRepository $sidebar, ManagerGroupService $manage_group)
    {
        $this->sidebar = $sidebar;
        $this->manage_group = $manage_group;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验证登录
        if (!Auth::guard('manager')->check()) {
            return redirect()->route('manage.login');
        }

        //超级管理员跳过鉴权
        if (Auth::guard('manager')->user()->can('manage', Manager::class)) {
            return $next($request);
        }

        //获取用户分组规则
        $rule = $this->manage_group->first(Auth::guard('manager')->user()['group'])['rule'] ? : null;

        //获取路由id
        $sidebar_id = $this->sidebar
            ->findWhere('route', $route = Route::currentRouteName(), '=', 'sidebar_id')['sidebar_id'] ? : $this->whitelist($route);

        //找到id,继续鉴权
        if ($sidebar_id) {
            foreach ($rule as $value) {
                if ($value == $sidebar_id) {
                    return $next($request);
                }
            }
        }

        //鉴权失败
        return response('没有权限访问!', 403);
    }

    /**
     * 搜索白名单获取菜单id
     *
     * @param $route
     * @return bool
     */
    public function whitelist($route)
    {
        //所有路由（有redis缓存）
        $all = $this->sidebar->all();

        foreach ($all as $value) {
            if (empty($value['whitelist'])) {
                continue;
            }

            $whitelists = unserialize($value['whitelist']);

            foreach ($whitelists as $whitelist) {
                if ($route == $whitelist) {
                    return $value['sidebar_id'];
                }
            }
        }

        return false;
    }
}
