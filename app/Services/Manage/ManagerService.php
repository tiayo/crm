<?php

namespace App\Services\Manage;

use App\Repositories\ManageRepositories;

class ManagerService
{
    protected $manage;

    public function __construct(ManageRepositories $manage)
    {
        $this->manage = $manage;
    }

    public function get()
    {
        return $this->manage->get();
    }
}