<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function login(Request $request)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        //find user
        $user = User::where('email', $request->email)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (empty($user)) {
            throw new \Exception('Invalid Credentials');
        }

        //check password
        if (!Hash::check($request->password, $user->password)) {
            throw new \Exception('Invalid Credentials');
        }

        //check status
        if ($user->status != User::STATUS_ACTIVE) {
            throw new \Exception('Your account is inactive');
        }

        //check resigned
        if (($user->resigned == User::RESIGNED_YES) && ($user->resign_date <= $current_date)) {
            throw new \Exception('Your account is resigned');
        }

        //check terminated
        if (($user->terminated == User::TERMINATED_YES) && ($user->terminate_date <= $current_date)) {
            throw new \Exception('Your account is terminated');
        }

        Auth::login($user, $request->remember_me ?? 0);
    }

}
