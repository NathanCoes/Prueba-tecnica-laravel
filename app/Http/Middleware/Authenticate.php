<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authentticate
{
    /**
    * Get the path the user should be redirected to.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return string
    */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('dashboard');
        }
    }
}
