<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'name',
        'id_user',
        'price'
    ];
}
