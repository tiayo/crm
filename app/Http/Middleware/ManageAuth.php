<?php

namespace App\Http\Middleware;

use App\Model\Manager;
use App\Model\Sidebar;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ManageAuth
{
    protected $sidebar;

    public function __construct(Sidebar $sidebar)
    {
        $this->sidebar = $sidebar;
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

        //鉴权(未显示时不可访问)
//        if (!Auth::guard('manager')->user()->can('manage', Manager::class)) {
//            if ($this->sidebar->select('index')->where('route',Route::currentRouteName())->first()['index'] != 1) {
//                return response('管理员未开启该模块或没有权限访问!', 403);
//            }
//        }

        return $next($request);
    }
}
