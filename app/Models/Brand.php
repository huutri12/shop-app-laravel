<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    protected static function booted()
    {
        static::saving(function ($m) {
            $m->slug = $m->slug ?: Str::slug($m->name);
        });
    }

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }
}
