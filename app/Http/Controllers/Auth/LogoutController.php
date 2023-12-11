<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use Illuminate\Support\Facades\Auth;

class LogoutController extends AuthController
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
