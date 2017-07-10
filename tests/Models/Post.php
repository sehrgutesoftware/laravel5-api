<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $dates = ['created_at', 'updated_at', 'publish_at'];
    protected $fillable = ['title', 'content', 'slug', 'publish_at'];

    public function comments()
    {
        return $this->hasMany('Tests\Models\Comment');
    }
}
