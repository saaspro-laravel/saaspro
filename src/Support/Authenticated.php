<?php

namespace SaasPro\Support;

use Illuminate\Support\Facades\Auth;

class Authenticated {


    protected static mixed $user = null; 
    protected $instance = null;

    static function user($relations = [], $guard = 'web'): mixed {
        if(!static::$user) { 
            static::$user = config('saaspro.user_model')::with($relations)->firstWhere('id', Auth::guard($guard)->id());
            return static::$user;
        }

        if(static::$user->id == Auth::guard($guard)->id()) {
            static::$user->load($relations);
        }

        return static::$user;
    }

}