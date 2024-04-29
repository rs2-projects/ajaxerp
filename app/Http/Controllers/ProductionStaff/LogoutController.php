<?php

namespace App\Http\Controllers\ProductionStaff;

use App\Http\Controllers\BaseControllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends AuthController
{
    public function logout()
    {
        Auth::guard('production-staff')->logout();
        session()->remove('session_permissions');
        return redirect()->route('login');
    }
}
