<?php

namespace App\Repositories;

use App\Model\Sidebar;
use App\Services\RedisServiceInterface;

class SidebarRepository
{
    protected $sidebar;
    protected $redis;

    public function __construct(Sidebar $sidebar, RedisServiceInterface $redis)
    {
        $this->sidebar = $sidebar;
        $this->redis = $redis;
    }

    public function all()
    {
        $redis = unserialize($this->redis->redisSingleGet('sidebar_get:all'));

        if (!$redis) {

            $info = $this->sidebar
                ->orderBy('position', 'desc')
                ->get()
                ->toArray();

            //写入redis
            $this->redis->redisSingleAdd('sidebar_get:all', serialize($info), 1800);

            return $info;
        }

        return $redis;
    }

    public function get($sidebars)
    {
        return $this->sidebar
            ->whereIn('sidebar_id', $sidebars)
            ->get();
    }

    public function getIndex($id)
    {
        return $this->sidebar
            ->where('index', $id)
            ->get();
    }

    public function find($id)
    {
        return $this->sidebar->find($id);
    }

    public function findWhereRoute($route)
    {
        return $this->sidebar
            ->where('route', $route)
            ->first();
    }

    public function findParent()
    {
        return $this->sidebar
            ->where('parent', 0)
            ->get();
    }

    public function findWhere($option, $value, $condition = '=', ...$select)
    {
        return $this->sidebar
            ->select(...$select)
            ->where($option, $condition, $value)
            ->first();
    }

    public function countExist($post)
    {
        return $this->sidebar
            ->where('type', $post['type'])
            ->where('alias', $post['alias'])
            ->count();
    }

    public function create($data)
    {
        $this->redis->redisMultiDelete('sidebar_get');

        return $this->sidebar->create($data);
    }

    public function update($id, $data)
    {
        $this->redis->redisMultiDelete('sidebar_get');

        return $this->sidebar
            ->where('sidebar_id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        $this->redis->redisMultiDelete('sidebar_get');

        return $this->sidebar
            ->where('sidebar_id', $id)
            ->delete();
    }
}
