<?php

namespace Tests\Controllers;

use SehrGut\Laravel5_Api\Controller;
use Tests\Models\Post;

class PostsController extends Controller
{
    protected $model = Post::class;
}
