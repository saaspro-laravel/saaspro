<?php

namespace Saaspro;

use Illuminate\Filesystem\Filesystem;

class Saaspro {

    public function plugins(){
        $files = new Filesystem;
        if(!$files->exists($path = base_path("bootstrap/cache/plugins.json"))) return [];
        return collect($files->json($path))
            ->filter(fn($item) => isset($item["providers"]))
            ->reduce(fn($carry, $value) => [...$carry, ...$value['providers']], []);
    }


}