<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Service\Manage\PluginService;
use App\Service\Manage\ManageService;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    protected $request;
    protected $manage;
    protected $plugins;

    public function __construct(Request $request, ManageService $manage, PluginService $plugins)
    {
        $this->request = $request;
        $this->manage = $manage;
        $this->plugins = $plugins;
    }

    public function index()
    {
        return view('manage.plugins.plugins_list', [
            'lists' => $this->plugins->lists(2),
        ]);
    }

}