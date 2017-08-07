<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Repositories\PluginRepositories;
use App\Service\Manage\PluginService;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    protected $plugins;
    protected $request;
    protected $plugin_db;

    public function __construct(PluginService $plugin, Request $request, PluginRepositories $plugin_db)
    {
        $this->plugins = $plugin;
        $this->request = $request;
        $this->plugin_db = $plugin_db;
    }

    /**
     * 显示后台插件
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminPlugins()
    {
        return view('manage.plugins.plugins_list', [
            'lists' => $this->plugins->lists(2),
        ]);
    }

    /**
     * 显示前台插件
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homePlugins()
    {
        return view('manage.plugins.plugins_list', [
            'lists' => $this->plugins->lists(1),
        ]);
    }

    /**
     * 添加插件视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        return view('manage.plugins.plugins_add_or_update', [
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('plugins_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 添加插件
     *
     */
    public function addPost()
    {
        $messages = [
            'alias.alpha' => '别名只能由英文字母组成！',
            'version.max' => '版本不要超过：max个字符！',
        ];

        $this->validate($this->request, [
            'type' => 'required|between:1,2',
            'name' => 'required',
            'alias' => 'required|alpha',
            'version' => 'required|max:10',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required|between:0,1',
        ], $messages);

        try {
            $post = $this->plugins->add($this->request->all());
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        $route = $this->plugins->redirctPlugins($post['id'], $post);

        return redirect()->route($route);
    }

    /**
     * 生成插件服务注册列表
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function generate()
    {
        try{
            $this->plugins->generate();
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return response('生成成功！');
    }

    /**
     * 安装插件
     *
     * @param $plugin_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function install($plugin_id)
    {
        try{
            $this->plugins->install($plugin_id);
        } catch (\Exception $e) {
            redirect()->back()
                ->withErrors($e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * 卸载插件
     *
     * @param $plugin_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function uninstall($plugin_id)
    {
        try{
            $this->plugins->install($plugin_id, 0);
        } catch (\Exception $e) {
            redirect()->back()
                ->withErrors($e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * 切换插件状态
     *
     * @param $plugin_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pluginStatus($plugin_id)
    {
        try{
            $this->plugins->pluginSwitch('status', $plugin_id);
        } catch (\Exception $e) {

        }

        return redirect()->back();
    }

    /**
     * 切换插在是否再首页显示
     *
     * @param $plugin_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pluginIndex($plugin_id)
    {
        try{
            $this->plugins->pluginSwitch('index', $plugin_id);
        } catch (\Exception $e) {

        }

        return redirect()->back();
    }

    /**
     * 更新插件信息视图
     *
     * @param $plugin_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($plugin_id)
    {
        if (empty($info = $this->request->session()->get('_old_input'))) {
            $info = $this->plugin_db->find($plugin_id);
        }

        if (empty($info)) {
            return response('插件不存在！');
        }

        return view('manage.plugins.plugins_add_or_update', [
            'old_input' =>  $info,
            'url' => Route('manage_plugins_update_post', ['plugin_id' => $plugin_id]),
            'sign' => 'update'
        ]);
    }

    /**
     * 更新插件信息
     *
     * @param $plugin_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updatePost($plugin_id)
    {
        $messages = [
            'version.max' => '版本不要超过:max个字符！',
        ];

        $this->validate($this->request, [
            'name' => 'required',
            'version' => 'required|max:10',
            'author' => 'required',
            'description' => 'required',
        ], $messages);

        $post = $this->request->all();

        try {
            $this->plugins->update($plugin_id, $post);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        $route = $this->plugins->redirctPlugins($plugin_id);

        return redirect()->route($route);

    }

    /**
     * 删除插件
     *
     * @param $plugin_id
     * @param $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($plugin_id, $type)
    {
        $route = $this->plugins->redirctPlugins($plugin_id);

        try {
            $this->plugins->delete($plugin_id, $type);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route($route);
    }
}