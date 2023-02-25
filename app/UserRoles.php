<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\Factory;

class UserRoles extends Model
{
    // use Factory;

    public function permissions()
    {
        return $this->hasMany(UserRolePermissions::class, 'role_id', 'id');
    }
}
