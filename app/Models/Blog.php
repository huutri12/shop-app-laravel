<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';

    protected $fillable = ['title', 'slug', 'author', 'image', 'description', 'content'];

    public function getSlugOrTitleSlugAttribute()
    {
        return $this->slug ?: (Str::slug($this->title) ?: 'post-' . $this->id);
    }

    public function rates()
    {
        return $this->hasMany(\App\Models\Rate::class, 'id_blog');
    }
}
