<?php

namespace App\Services\Manage;

use App\Repositories\ManagergroupRepository;
use Mockery\Exception;

class ManagerGroupService
{
    protected $manager_group;

    public function __construct(ManagergroupRepository $manager_group)
    {
        $this->manager_group = $manager_group;
    }

    public function get()
    {
        return $this->manager_group->get();
    }

    public function updateOrCreate($post, $id = null)
    {
        $add['rule'] = serialize($post['rule']);

        $add['name'] = $post['name'];

        return $this->manager_group->updateOrCreate($add, $id);
    }

    public function first($managergrop_id)
    {
        $group = $this->manager_group->first($managergrop_id);

        $group['rule'] = unserialize($group['rule']);
        
        return $group;
    }


}