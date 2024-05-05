<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Hr\EmployeeLoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends BackendController
{
    public function login($id){
        $admin_user_id = auth()->id();
        $user = User::where('id', $id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        
        if (empty($user)) {
            return redirect()->back()->with(['failed' => 'Invalid Employee!']);
        }

        Auth::login($user);
        $user->resetPermissionSession();
        session()->put('is_admin_access', true);
        session()->put('admin_user_id', $admin_user_id);

        return redirect()->route('dashboard');
        // $data = $this->service->loginData($id);
    }

    public function backToAdmin() {
        if(session()->has('is_admin_access') && (session()->get('is_admin_access') == true) && (session()->get('admin_user_id') != '')) {
            $admin_user_id = session()->get('admin_user_id');
            $user = User::where('id', $admin_user_id)->first();
            Auth::login($user);
            $user->resetPermissionSession();
            session()->remove('is_admin_access');
            session()->remove('admin_user_id');
            return redirect()->route('dashboard');
        } else {
            session()->remove('is_admin_access');
            session()->remove('admin_user_id');
            return redirect()->back()->with(['failed' => 'You have not the access!']);
        }
    }
}
