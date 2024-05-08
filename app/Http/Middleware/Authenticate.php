<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $redirectPath = $request->path();
        $redirectToString = '';
        if ($redirectPath != '/') {
            if($request->getQueryString() != null) {
                $redirectUri = $redirectPath.'?'.$request->getQueryString();
            } else {
                $redirectUri = $redirectPath;
            }
            $redirectToString = '?redirectTo='.$redirectUri;
        }
        return $request->expectsJson() ? null : route('login').$redirectToString;
    }
}
