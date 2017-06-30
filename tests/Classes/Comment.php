<?php

namespace Tests\Classes;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['text'];

    public function post()
    {
        return $this->belongsTo('Tests\Classes\Post');
    }
}
