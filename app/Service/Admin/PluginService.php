<?php

namespace App\Service\Admin;

use App\Repositories\PluginRepositories;

class PluginService
{
    protected $plugin;

    public function __construct(PluginRepositories $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * 生成插件服务类
     *
     * @return bool
     */
    public function generate()
    {
        $file = base_path().'/config/plugin_list.php';

        //获取所有已经激活的模块
        $activePlugins = $this->plugin->getStatus(1);

        //获取前后台插件文件夹名称
        $admin = config('plugin.admin_path');
        $home = config('plugin.home_path');

        //拼接目标字符串
        $array = '<?php'."\r\n\r\n".'return ['."\r\n\r\n";

        //循环拼接目标字符串
        foreach ($activePlugins as $plugin) {

            //判断插件类型(1为前台模块，2为后台模块)
            if ($plugin['type'] == 1) {
                $type_name = $home;
            } elseif ($plugin['type'] == 2) {
                $type_name = $admin;
            } else {
                continue;
            }

            $array .= '     '.'Plugins\\'.$type_name.'\\'.$plugin['alias'].'\\Providers\\'.$plugin['alias'].'Provider::class,'."\r\n";
        }

        //写入文件
        file_put_contents($file, $array."\r\n".'];');

        //执行完毕
        return true;
    }

    /**
     * 通过插件类型获取插件
     *
     * @param $type
     * @return mixed
     */
    public function lists($type)
    {
        return $this->plugin->getType($type);
    }

    /**
     * 更改插件状态
     *
     * @param $plugin_id
     * @return bool
     */
    public function pluginStatus($plugin_id)
    {
        //获取插件状态
        $info = $this->plugin->find($plugin_id);

        //初始化状态
        $status = 1;

        //判断更改状态
        if ($info['status'] == 1) {
            $status = 0;
        }

        //更新数组
        $map['status'] = $status;

        //更新
        $this->plugin->update($plugin_id, $map);

        //删除服务注册
        $this->generate();

        //完毕
        return true;
    }
}