<?php

namespace App\Repositories;

use App\Model\Manager;
use Illuminate\Support\Facades\Auth;

class ManageRepository
{
    protected $manage;

    public function __construct(Manager $manage)
    {
        $this->manage = $manage;
    }

    public function create($data)
    {
        return $this->manage->create($data);
    }

    public function getChildren($all_group)
    {
        $manage = [];

        foreach ($all_group as $group) {
            $result = $this->manage
                ->where('group', $group['managergroup_id'])
                ->join('managergroups', 'managergroup_id', 'group')
                ->select('managers.*', 'managergroups.name as group_name')
                ->get();

            $handles = $result->toArray();

            foreach ($handles as $handle) {
                if (!empty($result)) {
                    $manage[] = $handle;
                }
            }
        }

        return $manage;
    }

    public function firstJoinGroups($id)
    {
        return $this->manage
            ->where('id', $id)
            ->join('managergroups', 'managergroup_id', 'group')
            ->select('managers.*', 'managergroups.name as group_name')
            ->first();
    }

    public function first($id)
    {
        return $this->manage->find($id)->toArray();
    }

    public function superId()
    {
        return $this->manage
            ->orderby('id')
            ->first();
    }

    public function updateOrCreate($post, $id)
    {
        if (empty($id) && $id !== 0) {
            return $this->manage->create($post);
        }

        return $this->manage
            ->where('id', $id)
            ->update($post);
    }
}