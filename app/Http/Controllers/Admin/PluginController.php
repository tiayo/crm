<?php

namespace App\Http\Controllers\Admin;

use App\Service\Admin\PluginService;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class PluginController extends Container
{
    protected $plugins;
    protected $request;

    public function __construct(PluginService $plugin, Request $request)
    {
        $this->plugins = $plugin;
        $this->request = $request;
    }

    public function adminPlugins()
    {
        return view('admin.plugins.plugins_list', [
            'lists' => $this->plugins->lists(2),
        ]);
    }

    public function homePlugins()
    {
        return view('admin.plugins.plugins_list', [
            'lists' => $this->plugins->lists(1),
        ]);
    }

    public function generate()
    {
        try{
            $this->plugins->generate();
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return response('生成成功！');
    }

    public function pluginStatus($plugin_id)
    {
        try{
            $this->plugins->pluginStatus($plugin_id);
        } catch (\Exception $e) {

        }

        return redirect()->back();
    }
}