<?php

namespace App\Services\Manage;

use App\Model\Manager;
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
     * redis缓存.
     *超级管理员特权
     *
     * @return array
     */
    public function getChildren()
    {
        //超级管理员返回所有
        if (Auth::guard('manager')->user()->can('manage', Manager::class)) {
            return $this->manage->all()->toArray();
        }

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
     * 列出低于当前级别的.
     *
     * @return mixed
     */
    public function getGroup()
    {
        return $this->manager_group->getChildrenGroup(Auth::guard('manager')->user()['group'], 'managergroup_id', 'name');
    }

    /**
     * 查找指定id的用户.
     *
     * @param $id
     *
     * @return mixed
     */
    public function first($id)
    {
        return $this->manage->first($id);
    }


    /**
     * 更新或编辑
     * 鉴权在控制器中间件进行
     * 执行后需要�
     * 除redis.
     *
     * @param $post
     * @param null $id
     *
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
        } elseif (empty($id) && $id !== 0) {
            //默认密码
            $add['password'] = bcrypt('Abcd.123');
        }

        //执行
        $this->manage->updateOrCreate($add, $id);

        //删除redis缓存
        return $this->redis->redisMultiDelete('manageChildren');
    }

    /**
     * 删除记录
     * 鉴权在控制器中间件进行
     * 执行后需要�
     * 除redis.
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        //执行
        if ($this->manage->destroy($id)) {
            //删除redis缓存
            return $this->redis->redisMultiDelete('manageChildren');
        }

        return false;
    }
}
