<?php

namespace SaasPro\Facades;

use Illuminate\Support\Facades\Facade;
use SaasPro\SaasPro as SaasProSaasPro;
class Saaspro extends Facade {

    protected static function getFacadeAccessor() {
        return SaasProSaasPro::class;
    }

}