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
        $$name = app("App\\".ucwords(strtolower($name)));

        return $$name->find(Auth::guard($name)->id())->can($option, $class);
    }
}