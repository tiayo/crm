<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AdminService;
use App\Service\Admin\PluginService;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $request;
    protected $admin;
    protected $plugins;

    public function __construct(Request $request, AdminService $admin, PluginService $plugins)
    {
        $this->request = $request;
        $this->admin = $admin;
        $this->plugins = $plugins;
    }

    public function index()
    {
        return view('admin.plugins.plugins_list', [
            'lists' => $this->plugins->lists(2),
        ]);
    }

    public function test($id, Task $task)
    {
        $task = $task->find($id);

        if (!can('admin', 'view', $task)) {
            return response('被拒绝');
        }

        var_dump($task->toArray());
    }
}