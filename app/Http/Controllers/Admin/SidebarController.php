<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\SidebarService;
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

        return view('admin.sidebar.view', [
            'lists' => $all_sidebar,
        ]);
    }

    public function createView()
    {
        $all_sidebar = $this->sidebar->printArray($this->sidebar->tree($this->sidebar->all()));

        return view('admin.sidebar.add_or_update', [
            'all_sidebar' => $all_sidebar,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('admin_sidebar_add_post'),
            'sign' => 'add',
        ]);
    }

    public function createPost()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'route' => 'required|alpha_dash',
            'parent' => 'required|integer',
            'index' => 'required|integer|max:1|min:0|size:1',
            'position' => 'required|integer',
        ]);

        $this->sidebar->create($this->request->all());

        return redirect()->route('admin_sidebar_view');
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}