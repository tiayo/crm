<?php

use  App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;

if (!function_exists('can')) {
    /**
     * 权限验证
     * 全局辅助函数
     *
     * @param $option
     * @param null $class
     * @param string $guard
     * @return mixed
     */
    function can($option, $class = null, $guard = '')
    {
        $class = $class ?? Auth::guard($guard)->user();

        return Auth::guard($guard)->user()->can($option, $class);
    }
}

if (!function_exists('plugins_path')) {
    /**
     * 获取插件根目录.
     *
     * @param $name
     *
     * @return string
     */
    function plugins_path($name)
    {
        return app_path().'/Plugins/'.$name;
    }
}

if (!function_exists('plugin_index')) {
    /**
     * 生成插件首页路由.
     *
     * @param $plugin_id
     *
     * @return string
     */
    function plugin_index($plugin_id)
    {
        $info = \App\Model\Plugin::find($plugin_id);

        if ($info['type'] == 1) {
            $small_type = strtolower(config('plugin.user_path'));
        } elseif ($info['type'] == 2) {
            $small_type = strtolower(config('plugin.manage_path'));
        }

        $small_alias = strtolower($info['alias']);

        return route_defined($small_type.'_plugin_'.$small_alias);
    }
}

if (!function_exists('route_defined')) {
    /**
     * 路由不存在不报错.
     *
     * @param $route
     *
     * @return null|string
     */
    function route_defined($route)
    {
        try {
            Route($route);
        } catch (Exception $e) {
            return;
        }

        return Route($route);
    }
}

if(!function_exists('MailSend')) {
    /**
     * 邮件发送方法
     * 使用方法详见MailController的test方法
     *
     * @param $user
     * @param $data
     * @param $when
     */
    function MailSend($user, $data, $when)
    {
        MailController::email($user, $data, $when);
    }
}
