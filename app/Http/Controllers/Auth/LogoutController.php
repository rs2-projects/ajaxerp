<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use Illuminate\Support\Facades\Auth;

class LogoutController extends AuthController
{
    public function logout()
    {
        Auth::logout();
        session()->remove('session_permissions');
        session()->remove('is_admin_access');
        session()->remove('admin_user_id');
        return redirect()->route('login');
    }

}
