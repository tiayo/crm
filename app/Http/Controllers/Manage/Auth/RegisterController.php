<?php

namespace App\Http\Controllers\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Services\Manage\Auth\RegisterService;
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
        return view('manage.auth.register');
    }

    public function register()
    {
        $this->validate($this->request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:manages',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $this->register->register($this->request->all());

        return redirect()->route('manage');
    }
}