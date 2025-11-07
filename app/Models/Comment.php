<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id_blog',
        'id_user',
        'content',
        'avatar_user',
        'name_user',
        'level',
        'parent_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function children(){
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}
