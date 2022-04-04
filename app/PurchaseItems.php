<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    protected $fillable = [
        'item_name', 'unit_id'
    ];
}
