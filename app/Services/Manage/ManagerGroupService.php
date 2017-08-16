<?php

namespace App\Services\Manage;

use App\Repositories\ManagergroupRepository;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ManagerGroupService
{
    protected $manager_group;

    public function __construct(ManagergroupRepository $manager_group)
    {
        $this->manager_group = $manager_group;
    }

    /**
     * 获取所有分组
     *
     * @return mixed
     */
    public function get()
    {
        return $this->manager_group->get();
    }

    /**
     * 获取排除第一条（第一条默认为超级管理员配置）的所有分组
     *
     * @return mixed
     */
    public function getLower()
    {
        return $this->manager_group->getLower();
    }

    /**
     * 更新或编辑
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function updateOrCreate($post, $id = null)
    {
        $add['rule'] = serialize($post['rule']);

        $add['name'] = $post['name'];

        $add['parent_id'] = $post['parent_id'];

        return $this->manager_group->updateOrCreate($add, $id);
    }

    /**
     * 根据id获取单个分组
     *
     * @param $managergrop_id
     * @return mixed
     */
    public function first($managergrop_id)
    {
        $group = $this->manager_group->first($managergrop_id);

        $group['rule'] = unserialize($group['rule']);
        
        return $group;
    }

    /**
     * 获取第一条记录作为超级管理员分组
     * 返回id
     *
     * @return mixed
     */
    public function superId()
    {
        return $this->manager_group->superId();
    }

    public function getChildrenGroup($parent_id, ...$select)
    {
        return $this->manager_group->getChildrenGroup($parent_id, ...$select);
    }
}