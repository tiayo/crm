<?php

namespace App\Services\Manage;

class CreatePluginService
{
    protected $init_path;
    protected $file_path;
    protected $type;
    protected $small_type;
    protected $name;
    protected $alias;
    protected $small_alias;

    /**
     * 调度方法.
     *
     * @param $post
     */
    public function handle($post)
    {
        //获取基础数据
        if ($post['type'] == 1) {
            $this->type = config('plugin.user_path');
            $this->small_type = strtolower($this->type);
        } elseif ($post['type'] == 2) {
            $this->type = config('plugin.manage_path');
            $this->small_type = strtolower($this->type);
        }

        $this->name = $post['name'];
        $this->alias = $post['alias'];
        $this->small_alias = strtolower($post['alias']);

        $this->init_path = app_path().'/Plugins/Init/';
        $this->file_path = app_path().'/Plugins/'.$this->type.'/'.$this->alias.'/';

        //创建文件目录
        $this->path();

        //创建文件
        $this->file();

        return true;
    }

    /**
     * 文件列表.
     */
    public function file()
    {
        $file[1][] = 'config/config.txt';
        $file[1][] = 'config/config.php';

        $file[2][] = 'Controllers/Controllers.txt';
        $file[2][] = 'Controllers/IndexController.php';

        $file[3][] = 'Migration/Migration.txt';
        $file[3][] = 'Migration/Create'.$this->type.$this->alias.'Table.php';

        $file[4][] = 'Model/Model.txt';
        $file[4][] = 'Model/'.$this->alias.'.php';

        $file[5][] = 'Providers/Provider.txt';
        $file[5][] = 'Providers/'.$this->alias.'Provider.php';

        $file[6][] = 'views/index.blade.php';
        $file[6][] = 'views/index.blade.php';

        $file[7][] = 'routes.txt';
        $file[7][] = 'routes.php';

        foreach ($file as $value) {
            $this->writer($value);
        }
    }

    /**
     * 写�
     * �文件.
     *
     * @param $file
     */
    public function writer($file)
    {
        $content = file_get_contents($this->init_path.$file[0]);

        $content = $this->replace($content);

        $fp = fopen($this->file_path.$file[1], 'w');

        fwrite($fp, $content);

        fclose($fp);
    }

    /**
     * 文件夹列表.
     */
    public function path()
    {
        $file[] = $this->file_path.'config';
        $file[] = $this->file_path.'Controllers';
        $file[] = $this->file_path.'Migration';
        $file[] = $this->file_path.'Model';
        $file[] = $this->file_path.'Providers';
        $file[] = $this->file_path.'Services';
        $file[] = $this->file_path.'views';

        foreach ($file as $value) {
            $this->createFile($value);
        }
    }

    /**
     * 创建文件目录.
     *
     * @param $file
     *
     * @throws \Exception
     */
    public function createFile($file)
    {
        if (file_exists($file)) {
            throw new \Exception('目录已经存在，请检查插件名称重复！');
        }

        mkdir($file, 0775, true);
    }

    /**
     * 替换.
     *
     * @param $content
     *
     * @return mixed
     */
    public function replace($content)
    {
        $content = str_replace('<<type>>', $this->type, $content);
        $content = str_replace('<<small_type>>', $this->small_type, $content);
        $content = str_replace('<<name>>', $this->name, $content);
        $content = str_replace('<<alias>>', $this->alias, $content);
        $content = str_replace('<<small_alias>>', $this->small_alias, $content);

        return $content;
    }

    /**
     * 递归删除目录及文件.
     *
     * @param $dirname
     *
     * @return bool
     */
    public function destoryFile($dirname)
    {
        if (!file_exists($dirname)) {
            return false;
        }
        if (is_file($dirname) || is_link($dirname)) {
            return unlink($dirname);
        }
        $dir = dir($dirname);
        if ($dir) {
            while (false !== $entry = $dir->read()) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                //递归
                $this->destoryFile($dirname.DIRECTORY_SEPARATOR.$entry);
            }
        }
        $dir->close();

        return rmdir($dirname);
    }
}
