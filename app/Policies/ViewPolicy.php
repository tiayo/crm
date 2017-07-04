<?php

namespace App\Policies;

use App\Admin;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Task  $task
     * @return mixed
     */
    public function view(Admin $admin, Task $task)
    {
        return $admin->id === $task->user_id;
    }
}
