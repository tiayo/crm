<?php

namespace App\Http\Controllers\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Service\Manage\Auth\LoginService;
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
        return view('manage.auth.login', [
            'old_input' => $this->request->session()->get('_old_input'),
        ]);
    }

    public function login()
    {
        //验证
        $this->validate($this->request, [
            $this->username() => 'required|email',
            'password' => 'required|string',
            'code' => 'required|string|size:5',
        ]);

        //错误获取
        $errors = [$this->username() => trans('auth.failed')];

        //获取用户输入
        $username = $this->request->get($this->username());
        $password = $this->request->get('password');
        $code = $this->request->get('code');
        $session_code = $this->request->session()->pull('login_captcha');

        //验证码判断及验证帐号密码
        if ($code != $session_code) {
            $errors = ['code' => '验证码错误！'];
        } else if ($this->login->login($this->username(), $username, $password)) {
            return redirect()->route('manage');
        }

       return redirect()->route('manage.login')
           ->withInput($this->request->only($this->username(), 'remember'))
           ->withErrors($errors);
    }

    public function logout()
    {
        $this->login->logout();

        $this->request->session()->flush();

        $this->request->session()->regenerate();

        return redirect()->route('manage.login');
    }

    public function username()
    {
        return 'email';
    }
}