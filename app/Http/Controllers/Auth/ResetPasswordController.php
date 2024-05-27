<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\PasswordResetToken;
use App\Services\Auth\ForgotPasswordService;
use Carbon\Carbon;

class ResetPasswordController extends AuthController
{
    public function showResetPassword()
    {
        $this->setPageTitle("Verify Identity");
        $request = request();
        $email = $request->email;
        if (!isset(request()->email) || (request()->email == '')) {
            abort(404);
        }
        $token = PasswordResetToken::where('email', $email)
            ->orderBy('id', "DESC")
            ->first();
        if (empty($token)) {
            abort(410,"Invalid Token");
        }
        if ($token->created_at < Carbon::now()->subHour()) {
            abort(410,'Token Expired!');
        }

        if ($token->token != $request->token) {
            abort(410,"Invalid Token");
        }

        return $this->view('auth.reset-password');
    }

    public function submitResetPassword(ResetPasswordRequest $request, ForgotPasswordService $service)
    {
        try {
            $return = $service->resetPassword($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess($return, "Password Reset Success");
    }
}
