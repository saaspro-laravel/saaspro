<?php

namespace SaasPro;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use SaasPro\Console\DiscoverPlugins;
use SaasPro\Facades\Saaspro;

class SaasProServiceProvider extends ServiceProvider {

    public function boot(){
        if($this->app->runningInConsole()){
            $this->commands([
                DiscoverPlugins::class
            ]);
        }
    }

    public function register(){
        $this->loadPluginProviders();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    function loadPluginProviders(){
        collect(Saaspro::plugins())->each(function($provider){
            $this->app->singleton($provider, fn() => new $provider());       
        });
    }

}