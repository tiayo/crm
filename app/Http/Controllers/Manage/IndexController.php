<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\PluginService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $request;
    protected $manage;
    protected $plugins;

    public function __construct(Request $request, PluginService $plugins)
    {
        $this->request = $request;
        $this->plugins = $plugins;
    }

    public function index()
    {
        return view('manage.plugins.plugins_list', [
            'lists' => $this->plugins->lists(2),
        ]);
    }

}