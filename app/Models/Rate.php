<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';
    protected $fillable = ['rate', 'id_blog', 'id_user'];
}
