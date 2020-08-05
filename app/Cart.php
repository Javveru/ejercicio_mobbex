<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $table = 'carts';

    protected $fillable = [
        'total_price', 'user_id',
    ];
}
