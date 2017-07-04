<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Service\Admin\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $request;
    protected $login;

    public function __construct(Request $request, LoginService $login)
    {
        $this->request = $request;
        $this->login = $login;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login()
    {
        $this->validate($this->request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $errors = [$this->username() => trans('auth.failed')];

        $username = $this->request->get($this->username());
        $password = $this->request->get('password');

       if ($this->login->login($this->username(), $username, $password)) {
           return redirect()->route('admin');
       }

       return redirect()->route('admin.login')
           ->withInput($this->request->only($this->username(), 'remember'))
           ->withErrors($errors);
    }

    public function logout()
    {
        $this->login->logout();

        $this->request->session()->flush();

        $this->request->session()->regenerate();

        return redirect()->route('admin.login');
    }

    public function username()
    {
        return 'email';
    }
}