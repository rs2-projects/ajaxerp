<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use Illuminate\Http\Request;

class LoginController extends AuthController
{
    public function showLogin()
    {
        return view('auth.login');
    }
}
