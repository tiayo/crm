<?php

namespace App\Services\Manage;

use App\Repositories\ManageRepository;
use App\Services\RedisServiceInterface;
use Illuminate\Support\Facades\Auth;

class ManagerService
{
    protected $manage;
    protected $manager_group;
    protected $redis;

    public function __construct(ManageRepository $manage,
                                ManagerGroupService $manager_group,
                                RedisServiceInterface $redis)
    {
        $this->manage = $manage;
        $this->manager_group = $manager_group;
        $this->redis = $redis;
    }

    /**
     * 获取下级管理员
     * redis缓存
     *
     * @return array
     */
    public function getChildren()
    {
        $all_manage = unserialize($this->redis->redisSingleGet('manageChildren:'.Auth::guard('manager')->id()));

        if (empty($all_manage)) {
            $group = Auth::guard('manager')->user()['group'];

            $all_group = $this->manager_group->getChildrenGroup($group, 'managergroup_id');

            $all_manage = $this->manage->getChildren($all_group);

            //加上自己
            $me = $this->manage->firstJoinGroups(Auth::guard('manager')->id());

            //在数组头部插入自己后进行升序排序
            array_unshift($all_manage, $me->toArray());
            sort($all_manage);

            $this->redis->redisSingleAdd('manageChildren:'.Auth::guard('manager')->id(), $all_manage, 1800);
        }

        //升序排序
        return $all_manage;
    }

    /**
     * 获取分组
     * 仅列出低于当前级别的
     *
     * @return mixed
     */
    public function getGroup()
    {
        return $this->manager_group->getLower();
    }

    /**
     * 查找指定id的用户
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->manage->first($id);
    }

    /**
     * 获取超级管理员id
     * 默认数据表第一个管理员为超级管理员
     *
     * @return mixed
     */
    public function superId()
    {
        return $this->manage->superId();
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
        $add['name'] = $post['name'];

        $add['email'] = $post['email'];

        $add['group'] = $post['group'];

        $add['type'] = 2;

        //密码
        if (isset($post['password'])) {
            $add['password'] = bcrypt($post['password']);
        } else if(empty($id) && $id !== 0) {
            //默认密码
            $add['password'] = bcrypt('Abcd.123');
        }

        //执行
        $this->manage->updateOrCreate($add, $id);

        //删除redis缓存
        return $this->redis->redisMultiDelete('manageChildren');
    }
}