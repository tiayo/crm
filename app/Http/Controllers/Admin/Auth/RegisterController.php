<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Admin\Auth\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $request;
    protected $register;

    public function __construct(Request $request, RegisterService $register)
    {
        $this->request = $request;
        $this->register = $register;
    }

    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    public function register()
    {
        $this->validate($this->request, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $this->register->register($this->request->all());

        return redirect()->route('admin');
    }
}
