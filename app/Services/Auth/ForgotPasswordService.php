<?php

namespace App\Services\Auth;

use App\Mail\Auth\ForgotPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\Production\ProductionStaff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordService
{
    public function sentResetMail(Request $request)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        //find user
        $user = User::where('email', $request->email)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (empty($user)) {
            throw new \Exception('Invalid Email');
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

        $token = rand(100000, 999999);

        PasswordResetToken::create([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::to($user->email)->send(new ForgotPasswordMail($user, $token));

        return route('verify-identity', ['email' => $user->email]);
    }

    public function verifyIdentity($request)
    {
        $email = $request->email;
        $token = PasswordResetToken::where('email', $email)
            ->orderBy('id', "DESC")
            ->first();
        if (empty($token)) {
            throw new \Exception("Invalid Token");
        }
        if ($token->created_at < Carbon::now()->subHour()) {
            throw new \Exception('Token Expired!');
        }

        if ($token->token != $request->token) {
            throw new \Exception("Invalid Token");
        }

        return [
            'token' => $request->token,
            'redirectUri' => route('reset-password',['email' => $request->email,'token' => $request->token]),
            'email' => $request->email
        ];
    }

    public function resetPassword($request)
    {
        //verify and reset password
        $email = $request->email;
        $token = PasswordResetToken::where('email', $email)
            ->orderBy('id', "DESC")
            ->first();
        if (empty($token)) {
            throw new \Exception("Invalid Token");
        }
        if ($token->created_at < Carbon::now()->subHour()) {
            throw new \Exception('Token Expired!');
        }
        if ($token->token != $request->token) {
            throw new \Exception("Invalid Token");
        }

        $user = User::where('email', $email)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (empty($user)) {
            throw new \Exception("Invalid User!");
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return [
            'redirectUri' => route('login')
        ];
    }

}
