<?php

if (!function_exists('can')) {
    /**
     * 权限验证
     * 全局辅助函数
     *
     * @param $name //传入Model文件名
     * @param $option //传入权限操作名
     * @param $class //传入要核对的内容
     * @return mixed
     */
    function can($name, $option, $class)
    {
        $$name = app("App\Model\\".ucwords(strtolower($name)));

        return $$name->find(Auth::guard($name)->id())->can($option, $class);
    }
}

if (!function_exists('plugins_path')) {
    /**
     * 获取插件根目录
     *
     * @param $name
     * @return string
     */
    function plugins_path($name)
    {
        return app_path().'/Plugins/'.$name;
    }
}

if(!function_exists('plugin_index')) {

    function plugin_index($plugin_id)
    {
        $info = \App\Model\Plugin::find($plugin_id);

        if ($info['type'] == 1) {
            $small_type = strtolower(config('plugin.home_path'));
        } else if ($info['type'] == 2) {
            $small_type = strtolower(config('plugin.home_path'));
        }

        $small_alias = strtolower($info['alias']);

        return Route($small_type . '_plugin_' . $small_alias);
    }
}

if(!function_exists('route_defined')) {
    function route_defined($route)
    {
        try {
            Route($route);
        } catch (Exception $e) {
            return null;
        }

        return Route($route);
    }
}