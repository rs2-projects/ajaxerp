<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(config('app.force_https')) {
            if (mb_substr($request->url(),0,5) != 'https') {
                $url = 'https'.mb_substr($request->url(),4);
                return redirect()->to($url);
            }
        }
        return $next($request);
    }
}
