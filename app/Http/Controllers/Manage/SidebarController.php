<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\SidebarService;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    protected $sidebar;
    protected $request;

    public function __construct(SidebarService $sidebar, Request $request)
    {
        $this->sidebar = $sidebar;
        $this->request = $request;
    }

    public function view()
    {
        $all_sidebar = $this->sidebar->addParent($this->sidebar->printArray($this->sidebar->tree($this->sidebar->all())));

        return view('manage.sidebar.view', [
            'lists' => $all_sidebar,
        ]);
    }

    public function createView()
    {
        $all_sidebar = $this->sidebar->printArray($this->sidebar->tree($this->sidebar->all()));

        return view('manage.sidebar.add_or_update', [
            'all_sidebar' => $all_sidebar,
            'old_input'   => $this->request->session()->get('_old_input'),
            'url'         => Route('manage_sidebar_add'),
            'sign'        => 'add',
        ]);
    }

    public function update($id)
    {
        $all_sidebar = $this->sidebar->printArray($this->sidebar->tree($this->sidebar->all()));

        return view('manage.sidebar.add_or_update', [
            'all_sidebar' => $all_sidebar,
            'old_input'   => $this->sidebar->find($id),
            'url'         => Route('manage_sidebar_update', ['id' => $id, 'type' => 'update']),
            'sign'        => 'add',
        ]);
    }

    public function createOrUpdate($id = null, $type = null)
    {
        $this->validate($this->request, [
            'name'     => 'required',
            'route'    => 'alpha_dash',
            'parent'   => 'required|integer',
            'index'    => 'required|integer|min:0|max:1',
            'position' => 'required|integer',
        ]);

        $this->sidebar->createOrCreate($this->request->all(), $id, $type);

        return redirect()->route('manage_sidebar_view');
    }

    public function destroy($id)
    {
        try {
            $this->sidebar->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('manage_sidebar_view');
    }
}
