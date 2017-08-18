<?php

namespace App\Services\Manage;

use App\Model\Manager;
use App\Repositories\ManagergroupRepository;
use Illuminate\Support\Facades\Auth;

class ManagerGroupService
{
    protected $manager_group;

    public function __construct(ManagergroupRepository $manager_group)
    {
        $this->manager_group = $manager_group;
    }

    /**
     * 获取所有分组.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->manager_group->get();
    }

    /**
     * 获取排除第一条外的分组
     *
     * @return mixed
     */
    public function getLower()
    {
        return $this->manager_group->getLower();
    }

    /**
     * 更新或编辑.
     *
     * @param $post
     * @param null $id
     *
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
     * 根据id获取单个分组.
     *
     * @param $managergrop_id
     *
     * @return mixed
     */
    public function first($managergrop_id)
    {
        $group = $this->manager_group->first($managergrop_id);

        $group['rule'] = unserialize($group['rule']);

        return $group;
    }

    /**
     * 获取第一条记录
     *
     * @return mixed
     */
    public function superId()
    {
        return $this->manager_group->superId();
    }

    /**
     * 获取所有下级分组
     * 鉴权在控制器中间件.
     *
     * @param $parent_id
     * @param array ...$select
     *
     * @return array
     */
    public function getChildrenGroup($parent_id, ...$select)
    {
        //超级管理员返回所有
        if (Auth::guard('manager')->user()->can('manage', Manager::class)) {
            return $this->manager_group->get()->toArray();
        }

        $all_group = $this->manager_group->getChildrenGroup($parent_id, ...$select);

        //加上自己的分组
        //$me = $this->manager_group->first(Auth::guard('manager')->user()['group']);
        //array_unshift($all_group, $me->toArray());

        sort($all_group);

        return $all_group;
    }

    /**
     * 删除分组
     * 鉴权在控制器中间件.
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->manager_group->destroy($id);
    }
}
