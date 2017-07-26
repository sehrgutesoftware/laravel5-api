<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['post_id', 'text'];

    public function post()
    {
        return $this->belongsTo('Tests\Models\Post');
    }
}
