<?php

namespace Tests\Controllers;

use SehrGut\Laravel5_Api\Controller;
use SehrGut\Laravel5_Api\Plugins\RelationSplitter;
use Tests\Models\Post;

class RelativesController extends Controller
{
    protected $model = Post::class;

    protected $relations = ['comments'];

    protected $plugins = [
        RelationSplitter::class,
    ];
}
