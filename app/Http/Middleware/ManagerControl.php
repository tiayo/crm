<?php
/**
 * 当前用户是否有权限操作指定管理员中间件
 */
namespace App\Http\Middleware;

use App\Services\Manage\ManagerGroupService;
use Closure;
use App\Services\Manage\ManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerControl
{
    protected $manager;
    protected $manager_group;

    public function __construct(ManagerService $manager, ManagerGroupService $manager_group)
    {
        $this->manager = $manager;
        $this->manager_group = $manager_group;
    }

    public function handle(Request $request, Closure $next)
    {
        //获取操作的id
        $id = $request->route('id');
        $group = $request->get('group');

        //如果id未获取，则为添加，验证分组是否允许
        if (empty($id) && !empty($group)) {
            if ($this->create($group)) return $next($request);
        }
        //id不为空，则为更新，验证是否有权限
        else if(!empty($id)){
            if ($this->update($id)) return $next($request);
        }

        return response('您没有权限！', 403);
    }

    /**
     * 验证更新
     *
     * @param $id
     * @return bool
     */
    public function update($id)
    {
        $manager_children = $this->manager->getChildren();

        foreach ($manager_children as $children) {
            if ($children['id'] == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * 验证添加
     *
     * @param $group
     * @return bool
     */
    public function create($group)
    {
        $manager_children_group = $this->manager_group
            ->getChildrenGroup(Auth::guard('manager')->user()['group'], 'managergroup_id');

        foreach ($manager_children_group as $children) {
            if ($children['managergroup_id'] == $group) {
                return true;
            }
        }

        return false;
    }
}
