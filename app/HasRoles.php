<?php

namespace App;

trait HasRoles
{
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }
}
