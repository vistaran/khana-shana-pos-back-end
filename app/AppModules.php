<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factory;

class AppModules extends Model
{
    // use Factory;

    public function permissions()
    {
        return $this->hasMany(AppModulePermissions::class, 'module_id', 'id');
    }
}
