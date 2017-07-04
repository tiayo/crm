<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AdminService;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $request;
    protected $admin;

    public function __construct(Request $request, AdminService $admin)
    {
        $this->request = $request;
        $this->admin = $admin;
    }

    public function index()
    {
        echo '后台用户id：'.Auth::guard('admin')->id();
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