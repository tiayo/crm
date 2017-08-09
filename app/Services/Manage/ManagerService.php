<?php

namespace App\Services\Manage;

use App\Repositories\ManageRepository;

class ManagerService
{
    protected $manage;

    public function __construct(ManageRepository $manage)
    {
        $this->manage = $manage;
    }

    public function get()
    {
        return $this->manage->get();
    }
}