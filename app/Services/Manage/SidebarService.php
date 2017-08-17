<?php

namespace App\Services\Manage;

use App\Repositories\SidebarRepository;
use App\Services\RedisServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidebarService
{
    protected $sidebar;
    protected $redis;
    protected $request;

    public function __construct(SidebarRepository $sidebar, RedisServiceInterface $redis, Request $request)
    {
        $this->sidebar = $sidebar;
        $this->redis = $redis;
        $this->request = $request;
    }

    /**
     * 获取所有菜单.
     *
     * @return mixed
     */
    public function all()
    {
        return $lists = $this->sidebar->all()->toArray();
    }

    /**
     * 获取显示的菜单.
     *
     * @return mixed
     */
    public function allOutIndex()
    {
        //从redis获取缓存
        $cache = $this->redis->redisSingleGet('sidebar:'.Auth::guard('manager')->id());

        if (empty($cache)) {
            //获取数据
            $cache = $this->sidebar->getIndex(1)->toArray();

            //存储到redis(过期时间：30分钟)
            $this->redis->redisSingleAdd('sidebar:'.Auth::guard('manager')->id(), $cache, 1800);
        } else {
            //取出缓存转为数组

            $cache = unserialize($cache);
        }

        return $cache;
    }

    /**
     * 往所有菜单数组单项插�
     * �顶级栏目名称.
     *
     * @param $lists
     *
     * @return array
     */
    public function addParent($lists)
    {
        foreach ($lists as $list) {
            if ($list['parent'] == 0) {
                $list['parent_t'] = '顶级栏目';
            } else {
                $list['parent_t'] = $this->sidebar->find($list['parent'])['name'];
            }

            $result[] = $list;
        }

        return $result;
    }

    /**
     * 创建目录树.
     *
     * @param $items
     *
     * @return mixed
     */
    public function tree($items)
    {
        $childs = [];

        foreach ($items as &$item) {
            $childs[$item['parent']][] = &$item;
        }

        unset($item);

        foreach ($items as &$item) {
            if (isset($childs[$item['sidebar_id']])) {
                $item['childs'] = $childs[$item['sidebar_id']];
            }
        }

        return $this->sort($childs[0]);
    }

    /**
     * 根据position反向排序（数字越大越考前）.
     *
     * @param $array
     *
     * @return mixed
     */
    public function sort($array)
    {
        array_multisort(array_column($array, 'position'), SORT_DESC, $array);

        return $array;
    }

    /**
     * 处理侧边栏显示顺序.
     *
     * @param $tree
     *
     * @return array
     */
    public function printArray($tree)
    {
        foreach ($tree as $t) {
            $t['childs'] = isset($t['childs']) ? $t['childs'] : null; //No report index does not exist

            //子级栏目
            if ($t['parent'] != 0 && $t['childs'] == '') {
                $t['name'] = '--'.$t['name'];
                $result[] = $t;
            }
            //父级栏目
            else {
                $children = [];

                //二级目录顶级目录加前缀
                if ($t['parent'] != 0) {
                    $t['name'] = '--'.$t['name'];
                    $t['childs'] = $this->addPrefix($t['childs'], '--');
                }

                $result[] = $t;

                if ($t['childs']) {
                    $children = $this->printArray($t['childs']);
                }
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }

    /**
     * 无限极添加前缀
     *
     * @param $array
     * @param $prefix
     *
     * @return array|string
     */
    public function addPrefix($array, $prefix)
    {
        foreach ($array as $key => $value) {
            $value['name'] = $prefix.$value['name'];
            $result[$key] = $value;

            if (isset($value['childs'])) {
                $result[$key]['childs'] = $this->addPrefix($value['childs'], $prefix);
            }
        }

        return $result;
    }

    public function createOrCreate($post, $id = null, $type = null)
    {
        $map['name'] = $post['name'];
        $map['route'] = !isset($post['route']) ? null : $post['route'];
        $map['parent'] = $post['parent'];
        $map['index'] = $post['index'];
        $map['position'] = $post['position'];

        if (!empty($id) && $type == 'update') {
            //更新
            $this->sidebar->update($id, $map);
        } else {
            //创建
            $this->sidebar->create($map);
        }

        //清空redis数据库缓存
        return $this->redis->redisMultiDelete('sidebar');
    }

    public function breadcrumb($route)
    {
        $result[] = $current = $this->sidebar->findWhereRoute($route);

        if (empty($current)) {
            return [];
        }

        $result[] = $parent = $this->sidebar->find($current['parent']);

        while ($parent['parent'] != 0) {
            $parent = $this->sidebar->find($parent['parent']);
            $result[] = $parent;
        }

        return array_filter($result);
    }

    public function find($id)
    {
        return $this->sidebar->find($id);
    }

    public function destroy($id)
    {
        $this->sidebar->delete($id);

        //清空redis数据库缓存
        return $this->redis->redisMultiDelete('sidebar');
    }
}
