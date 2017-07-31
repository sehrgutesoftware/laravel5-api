<?php

namespace Tests\Controllers;

use SehrGut\Laravel5_Api\Controller;
use Tests\Models\Post;

class PostsWithCommentsController extends Controller
{
    protected $model = Post::class;

    protected $relations = ['comments'];

    protected $counts = ['comments'];
}
