<?php

namespace App\Repositories;

use App\Model\Sidebar;

class SidebarRepository
{
    protected $sidebar;

    public function __construct(Sidebar $sidebar)
    {
        $this->sidebar = $sidebar;
    }

    public function all()
    {
        return $this->sidebar
            ->orderBy('position', 'desc')
            ->get();
    }

    public function getIndex($id)
    {
        return $this->sidebar
            ->where('index', $id)
            ->get();
    }

    public function update($id, $data)
    {
        return $this->sidebar
            ->where('sidebar_id', $id)
            ->update($data);
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

    public function create($data)
    {
        return $this->sidebar->create($data);
    }

    public function countExist($post)
    {
        return $this->sidebar
            ->where('type', $post['type'])
            ->where('alias', $post['alias'])
            ->count();
    }

    public function delete($id)
    {
        return $this->sidebar
            ->where('sidebar_id', $id)
            ->delete();
    }

    public function get($sidebars)
    {
        return $this->sidebar
            ->whereIn('sidebar_id', $sidebars)
            ->get();
    }

    public function findParent()
    {
        return $this->sidebar
            ->where('parent', 0)
            ->get();
    }
}
