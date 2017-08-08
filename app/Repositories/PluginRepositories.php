<?php

namespace App\Repositories;

use App\Model\Plugin;

class PluginRepositories
{
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getStatus($type)
    {
        return $this->plugin
            ->where('status', $type)
            ->get();
    }

    public function getType($type)
    {
        return $this->plugin
            ->where('type', $type)
            ->orderby('plugin_id', 'desc')
            ->get();
    }

    public function update($id, $data)
    {
        return $this->plugin
            ->where('plugin_id', $id)
            ->update($data);
    }

    public function find($id)
    {
        return $this->plugin->find($id);
    }

    public function create($data)
    {
        return $this->plugin->create($data);
    }

    public function countExist($post)
    {
        return $this->plugin
            ->where('type', $post['type'])
            ->where('alias', $post['alias'])
            ->count();
    }

    public function delete($id)
    {
        return $this->plugin
            ->where('plugin_id', $id)
            ->delete();
    }
}