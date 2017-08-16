<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ManagePolicy
{
    use HandlesAuthorization;

    /**
     * 判断超级管理员
     *
     * @param $manage
     * @return bool
     */
    public function manage($manage)
    {
        return $manage['name'] === config('site.manage');
    }
}
