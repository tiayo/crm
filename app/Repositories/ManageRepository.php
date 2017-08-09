<?php

namespace App\Repositories;

use App\Model\Manage;

class ManageRepository
{
    protected $manage;

    public function __construct(Manage $manage)
    {
        $this->manage = $manage;
    }

    public function create($data)
    {
        return $this->manage->create($data);
    }

    public function get()
    {
        return $this->manage->get();
    }
}