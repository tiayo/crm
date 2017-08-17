<?php

namespace App\Services\Manage;

use App\Repositories\PluginRepository;

class PluginService
{
    protected $plugin;
    protected $create;

    public function __construct(PluginRepository $plugin, CreatePluginService $create)
    {
        $this->plugin = $plugin;
        $this->create = $create;
    }

    /**
     * 生成插件服务类.
     *
     * @return bool
     */
    public function generate()
    {
        $file = base_path().'/config/plugin_list.php';

        //获取所有已经激活的模块
        $activePlugins = $this->plugin->getStatus(1);

        //获取前后台插件文件夹名称
        $manage_path = config('plugin.manage_path');
        $user_path = config('plugin.user_path');

        //拼接目标字符串
        $array = '<?php'."\r\n\r\n".'return ['."\r\n\r\n";

        //循环拼接目标字符串
        foreach ($activePlugins as $plugin) {

            //判断插件类型(1为前台模块，2为后台模块)
            if ($plugin['type'] == 1) {
                $type_name = $user_path;
            } elseif ($plugin['type'] == 2) {
                $type_name = $manage_path;
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
     * 添加插件.
     *
     * @param $post
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function add($post)
    {
        $map['type'] = $post['type'];
        $map['name'] = $post['name'];
        $map['alias'] = $post['alias'];
        $map['version'] = $post['version'];
        $map['author'] = $post['author'];
        $map['description'] = $post['description'];
        $map['status'] = $post['status'];

        //判断别名是否重复
        if ($this->plugin->countExist($post) > 0) {
            throw new \Exception('插件名称已经存在数据啦，请更换！');
        }

        //执行创建逻辑
        if ($this->create->handle($post)) {
            //写入数据库
            $this->plugin->create($post);

            //生成服务注册文件
            $this->generate();
        }

        return true;
    }

    /**
     * 安�
     * 插件.
     *
     * @param $plugin_id
     * @param int $option
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function install($plugin_id, $option = 1)
    {
        //获取插件信息
        $info = $this->plugin->find($plugin_id);

        //获取插件信息
        $name = strtolower($info['alias']);
        if ($info['type'] == 1) {
            $type = strtolower(config('plugin.user_path'));
        } elseif ($info['type'] == 2) {
            $type = strtolower(config('plugin.manage_path'));
        }

        //未获取到插件抛错
        if (!isset($type) || empty($type)) {
            throw new \Exception('插件类型异常！');
        }

        //获取操作
        if ($option) {
            $option = 'up';
        } else {
            $option = 'down';
        }

        //引入migration文件
        try {
            app($type.'_'.$name.'_migration')->$option();
        } catch (\Exception $e) {
        }

        //执行状态更新
        $this->pluginSwitch('install', $plugin_id);

        //完毕
        return true;
    }

    /**
     * 通过插件类型获取插件.
     *
     * @param $type
     *
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
     *
     * @return bool
     */
    public function pluginSwitch($type, $plugin_id, $switch = [0, 1])
    {
        //获取插件状态
        $info = $this->plugin->find($plugin_id);

        //初始化
        $result = $switch[1];

        //判断更改状态
        if ($info[$type] == $switch[1]) {
            $result = $switch[0];
        }

        //更新数组
        $map[$type] = $result;

        //更新
        $this->plugin->update($plugin_id, $map);

        //删除服务注册
        $this->generate();

        //完毕
        return true;
    }

    /**
     * 更新插件信息
     * 插件别名、类型无法修改.
     *
     * @param $plugin_id
     * @param $post
     *
     * @return mixed
     */
    public function update($plugin_id, $post)
    {
        $map['name'] = $post['name'];
        $map['version'] = $post['version'];
        $map['author'] = $post['author'];
        $map['description'] = $post['description'];
        $map['status'] = isset($post['status']) ? $post['status'] : 0;

        return $this->plugin->update($plugin_id, $map);
    }

    /**
     * 删除插件（两种类型）.
     *
     * @param $plugin_id
     * @param $type
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function delete($plugin_id, $type)
    {
        //获取插件信息
        $info = $this->plugin->find($plugin_id);

        //删除数据库记录库
        $this->plugin->delete($plugin_id);

        //重新生成注册服务
        $this->generate();

        //判断类型
        if ($type == 'only') {
            return true;
        }

        //判断类型失败
        if ($type != 'all') {
            throw new \Exception('删除类型未定义，请到目录删除文件！');
        }

        //插件别名
        $alias = $info['alias'];

        //删除数据库（如果有）
        try {
            app(strtolower($type).'_'.strtolower($alias).'_migration')->down();
        } catch (\Exception $e) {
        }

        //开始删除文件
        if ($info['type'] == 1) {
            $type = config('plugin.user_path');
        } elseif ($info['type'] == 2) {
            $type = config('plugin.manage_path');
        }

        $file = app_path().'/Plugins/'.$type.'/'.$alias.'/';

        $this->create->destoryFile($file);

        return true;
    }

    /**
     * 跳转到对应的插件列表.
     *
     * @param $plugin_id
     * @param null $post
     *
     * @return string
     */
    public function redirctPlugins($plugin_id, $post = null)
    {
        if (empty($post)) {
            $info = $this->plugin->find($plugin_id);
        } else {
            $info = $post;
        }

        $route = 'manage_plugins';

        if ($info['type'] == 1) {
            $route = 'user_plugins';
        }

        return $route;
    }
}
