<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $request;
    protected $admin;
    protected $plugins;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('admin.index');
    }
}
