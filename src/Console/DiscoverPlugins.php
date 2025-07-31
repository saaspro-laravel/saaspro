<?php

namespace SaasPro\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DiscoverPlugins extends Command {

    protected $signature = "saaspro:discover";

    protected $description = 'Cache SaasPro Plugins';

    function handle(){
        $this->warn("Discovering SaasPro Plugins...");
        $this->line('');
        
        $packages = [];
        $files = new Filesystem;
        $vendor_path = base_path('vendor');

        if ($files->exists($path = "$vendor_path/composer/installed.json")) { 
            $installed = json_decode($files->get($path), true);
            $packages = $installed['packages'] ?? $installed;
        }

        $plugins = [];

        foreach ($packages as $package) {
            if(!isset($package['extra']['saaspro'])) continue;
            $plugins[$package["name"]] = $package['extra']['saaspro'];
        }

        $files->replace(base_path("bootstrap/cache/plugins.json"), json_encode($plugins, JSON_PRETTY_PRINT));

        if(($count = count($plugins)) < 1) return $this->info("No SaasPro plugins found.");
        $text = $count === 1 ? 'plugin' : 'plugins';

        $this->info("{$count} {$text} discovered and cached successfully.");
    }

}