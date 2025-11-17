<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
    protected $table = 'product';   

    protected $fillable = [
        'id_user',
        'name',
        'price',
        'id_category',
        'id_brand',
        'status',
        'sale',
        'company',
        'image',
        'detail'
    ];

    public function getImagesAttribute(): array
    {
        $raw = $this->attributes['image'] ?? '[]';
        return json_decode($raw, true) ?: [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
