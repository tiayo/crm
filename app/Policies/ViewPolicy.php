<?php

namespace App\Policies;

use App\Model\Admin;
use App\Model\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param \App\Model\Admin $admin
     * @param \App\Model\Task  $task
     *
     * @return mixed
     */
    public function view(Admin $admin, Task $task)
    {
        return $admin->id === $task->user_id;
    }
}
