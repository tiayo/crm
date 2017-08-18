<?php

namespace App\Http\Middleware;

use App\Model\Manager;
use Closure;
use Illuminate\Support\Facades\Auth;

class SuperManage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard('manager')->user()->can('manage', Manager::class)) {
            return response('没有权限', 403);
        }

        return $next($request);
    }
}
