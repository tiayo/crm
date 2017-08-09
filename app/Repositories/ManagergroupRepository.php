<?php

namespace App\Repositories;

use App\Model\Managergroup;

class ManagergroupRepository
{
    protected $manager_group;

    public function __construct(Managergroup $manager_group)
    {
        $this->manager_group = $manager_group;
    }

    public function get()
    {
        return $this->manager_group->get();
    }

    public function updateOrCreate($post, $id)
    {
        if (empty($id) && $id !== 0) {
            return $this->manager_group->create($post);
        }

        return $this->manager_group
            ->where('managergroup_id', $id)
            ->update($post);
    }

    public function first($managergrop_id)
    {
        return $this->manager_group->find($managergrop_id);
    }
}