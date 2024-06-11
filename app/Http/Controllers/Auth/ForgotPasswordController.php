<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\VerifyForgotPasswordRequest;
use App\Models\PasswordResetToken;
use App\Services\Auth\ForgotPasswordService;
use Carbon\Carbon;

class ForgotPasswordController extends AuthController
{
    public function showForgotPassword()
    {
        $this->setPageTitle("Forgot Password");
        return $this->view('auth.forgot-password');
    }

    public function submitForgotPassword(ForgotPasswordRequest $request, ForgotPasswordService $service)
    {
        try {
            $redirectUri = $service->sentResetMail($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([
            'login' => 'success',
            'redirectUri' => $redirectUri,
        ], "Sent email success");
    }

    public function showForgotPasswordIdentity()
    {
        $this->setPageTitle("Verify Identity");
        if (!isset(request()->email) || (request()->email == '')) {
            abort(404);
        }
        $email = request()->email;
        $token = PasswordResetToken::where('email', $email)
            ->orderBy('id', "DESC")
            ->first();
        if (empty($token)) {
            abort(404);
        }
        if ($token->created_at < Carbon::now()->subHour()) {
            abort(410, 'Token Expired!');
        }

        return $this->view('auth.verify-identity');
    }

    public function submitForgotPasswordIdentity(VerifyForgotPasswordRequest $request, ForgotPasswordService $service)
    {
        try {
            $return = $service->verifyIdentity($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess($return, "Verify Identity Success");
    }
}
