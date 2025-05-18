<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ClearRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if current path doesn't start with register/classroom
        if (session()->has('registration.classroom') && !Route::is('register.classroom.*')) {
            session()->forget('registration.classroom');
        }

        if (session()->has('registration.course') && !Route::is('register.course.*')) {
            session()->forget('registration.course');
        }

        return $next($request);

        // return $response;
    }
}
