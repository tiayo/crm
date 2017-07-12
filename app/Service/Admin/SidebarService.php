<?php

namespace App\Service\Admin;

use App\Repositories\SidebarRepositories;

class SidebarService
{
    protected $sidebar;

    public function __construct(SidebarRepositories $sidebar)
    {
        $this->sidebar = $sidebar;
    }

    public function all()
    {
        return $lists = $this->sidebar->all()->toArray();
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
     * 创建目录树
     *
     * @param $items
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

        return $childs[0];
    }

    /**
     * 处理侧边栏显示顺序
     *
     * @param $tree
     * @return array
     */
    public function printArray($tree)
    {
        foreach ($tree as $t) {
            $t['childs'] = isset($t['childs']) ? $t['childs'] : null;//No report index does not exist

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

    public function create($post)
    {
        $map['name'] = $post['name'];
        $map['route'] = $post['route'];
        $map['parent'] = $post['parent'];
        $map['index'] = $post['index'];
        $map['position'] = $post['position'];

        return $this->sidebar->create($map);
    }

    public function breadcrumb($route)
    {
        $result[] = $current = $this->sidebar->findWhereRoute($route);

        $result[] = $parent =  $this->sidebar->find($current['parent']);

        while ($parent['parent'] != 0) {
            $parent = $this->sidebar->find($parent['parent']);
            $result[] = $parent;
        }

        return $result;
    }
}