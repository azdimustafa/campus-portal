<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Subfission\Cas\Facades\Cas;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            if (env('APP_CAS'))
                return route('cas');
            
            /**
             * user already sign in using cas. But the user is not in the laravel user
             * Then redirect back to home. 
             */
            if (Cas::isAuthenticated()){
                if (Auth::guest())
                    return route('home');
            }

            return route('home');
        }
    }

}
