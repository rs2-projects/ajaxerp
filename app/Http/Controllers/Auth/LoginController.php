<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends AuthController
{
    public function showLogin()
    {
        return $this->view('auth.login');
    }

    public function login(LoginRequest $request, LoginService $loginService)
    {
        try {
            $redirectUri = $loginService->login($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([
            'login' => 'success',
            'redirectUri' => $redirectUri,
        ], "Login Success");
    }
}
