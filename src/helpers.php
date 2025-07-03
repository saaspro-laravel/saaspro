<?php

use SaasPro\Support\Authenticated;
use SaasPro\Support\Locale;
use SaasPro\Support\State;
use SaasPro\Support\Toast;

if(!function_exists('state')) {
    function state(mixed $status, mixed $message = '', $data = []){
        $state = new State($status, $message, $data);
        return [$state->status, $state->message, $state->data];
    }
}

if(!function_exists('authenticated')){
    function authenticated($relations = [], $guard = 'web')  {
        return Authenticated::user($relations, $guard);
    }
}


if(!function_exists('toast')) {
    function toast($message, $title = null){
        return new Toast($message, $title);
    }
}