<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AdminService;
use App\Service\Admin\PluginService;
use Illuminate\Http\Request;

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

}