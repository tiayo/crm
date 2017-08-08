<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\ManagerService;

class ManagerController extends Controller
{
    protected $manage;

    public function __construct(ManagerService $manage)
    {
        $this->manage = $manage;
    }

    public function view()
    {
        $managers = $this->manage->get();

        return view('manage.manager.list', [
            'managers' => $managers,
        ]);
    }
}