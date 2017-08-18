<?php

namespace App\Services\Manage;

use App\Model\Manager;
use App\Repositories\SidebarRepository;
use Illuminate\Support\Facades\Auth;

class SidebarService
{
    protected $sidebar;
    protected $manager_group;

    public function __construct(SidebarRepository $sidebar, ManagerGroupService $manager_group)
    {
        $this->sidebar = $sidebar;
        $this->manager_group = $manager_group;
    }

    public function all()
    {
        $sidebars = $lists = $this->sidebar->all();

        $result = [];

        foreach ($sidebars as $sidebar) {

            if (!empty($sidebar['whitelist'])) {
                $sidebar['whitelist'] = implode(unserialize($sidebar['whitelist']), ',');
            }

            $result[] = $sidebar;
        }

        return $result;
    }

    /**
     * 获取指定的菜单.
     * 超级管理员有特权
     *
     * @param array $rule
     *
     * @return array
     */
    public function get($rule)
    {
        //超级管理员返回所有
        if (Auth::guard('manager')->user()->can('manage', Manager::class)) {
            return $this->all();
        }

        //规则为空时
        if (empty($rule)) {
            $rule = [];
        }

        //添加所有父极菜单
        $all_parent = $this->sidebar->findParent()->toArray();

        //合并数组并返回
        return array_merge($all_parent, $this->sidebar->get($rule)->toArray());
    }

    /**
     * 获取显示的菜单
     *
     * @param $rule
     * @return mixed
     */
    public function allOutIndex()
    {
        $group = Auth::guard('manager')->user()->group;

        $rule = $this->manager_group->first($group)['rule'];

        $all_sidebar = $this->get($rule);

        foreach ($all_sidebar as $key => $sidebar) {
            if ($sidebar['index'] != 1) {
                unset($all_sidebar[$key]);
            }
        }

        return $all_sidebar;
    }

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
     * 根据position反向排序.
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

    public function post($post, $id = null, $type = null)
    {
        $map['name'] = $post['name'];
        $map['route'] = !isset($post['route']) ? null : $post['route'];
        $map['parent'] = $post['parent'];
        $map['index'] = $post['index'];
        $map['position'] = $post['position'];
        $map['whitelist'] = serialize(explode(',', $post['whitelist']));

        if (!empty($id) && $type == 'update') {
            return $this->sidebar->update($id, $map);
        }

        return $this->sidebar->create($map);
    }

    public function breadcrumb($route)
    {
        $result[] = $current = $this->sidebar->findWhereRoute($route);

        $result[] = $parent = $this->sidebar->find($current['parent']);

        while ($parent['parent'] != 0) {
            $parent = $this->sidebar->find($parent['parent']);
            $result[] = $parent;
        }

        return array_filter($result);
    }

    public function find($id)
    {
        $result = $this->sidebar->find($id);

        if (!empty($result['whitelist'])) {
            $result['whitelist'] = implode(unserialize($result['whitelist']), ',');
        }

        return $result;
    }

    public function findWhere($option, $value, $condition = '=', ...$select)
    {
        return $this->sidebar->findWhere($option, $value, $condition = '=', ...$select);
    }

    public function destroy($id)
    {
        return $this->sidebar->delete($id);
    }
}
