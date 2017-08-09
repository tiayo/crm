<?php

namespace App\Services\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Auth;

class LoginService extends Controller
{
    protected $admin;

    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

    public function login($name, $username, $password)
    {
        $credentials = [
            $name => $username,
            'password' => $password,
        ];

        if(!Auth::guard('manage')->attempt($credentials)){
            return false;
        }

        return true;
    }

    public function logout()
    {
        return Auth::guard('manage')->logout();
    }
}