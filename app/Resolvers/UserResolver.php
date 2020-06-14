<?php

namespace App\Resolvers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\User;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        $guards = config('audit.user.guards'); 
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
    }
}