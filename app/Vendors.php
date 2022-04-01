<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    protected $fillable = [
        'name', 'phone_numbers', 'address', 'status'
    ];
}
