<?php

namespace SaasPro\Concerns\Models;

use SaasPro\Enums\Roles;

trait HasRole {

    protected $role;

    protected $defaultRole;
    
    function initializeHasRole() {
        $this->role = $this->setRoleEnum();

        $this->fillable[] = 'role';
        $this->mergeCasts([
            'role' => Roles::class
        ]);

        if(!isset($this->attributes['status'])) {
            if($this->status::tryFrom(Roles::USER->value)) {
                $this->setAttribute('role', $this->role::USER);
            }
        }
    }

    protected function setRoleEnum(){
        return Roles::class;
    }

    function scopeByRole($query, Roles $role) {
        return $query->where('role', $role);
    }

}