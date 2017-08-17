<?php

namespace App\Repositories;

use App\Model\Admin;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function create($data)
    {
        return $this->admin->create($data);
    }
}
