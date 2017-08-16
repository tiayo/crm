<?php

namespace App\Repositories;

use App\Model\Managergroup;

class ManagergroupRepository
{
    protected $manager_group;
    protected $getChildrenGroup_select;

    public function __construct(Managergroup $manager_group)
    {
        $this->manager_group = $manager_group;
    }

    public function get()
    {
        return $this->manager_group->get();
    }

    public function getChildrenGroup($parent_id, ...$select)
    {
        if (empty($this->getChildrenGroup_select)) {
            $this->getChildrenGroup_select = implode(',', $select);
        }

        $all_group = $this->manager_group
            ->select($this->getChildrenGroup_select)
            ->where('parent_id', $parent_id)
            ->get()
            ->toArray();

        if (!isset($result)) {
            $result = $all_group;
        }

        if (is_array($all_group) || is_object($all_group)) {
            foreach ($all_group as $group) {

                if (!isset($group['managergroup_id'])) {
                    continue;
                }

                $result = array_merge($result, $this->getChildrenGroup($group['managergroup_id']));
            }
        }

        return $result;
    }

    public function getLower()
    {
        return $this->manager_group
            ->skip(1)
            ->take(10)
            ->get();
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

    public function superId()
    {
        return $this->manager_group->select('managergroup_id')->orderby('managergroup_id')->first()['managergroup_id'];
    }
}