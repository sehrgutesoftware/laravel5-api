<?php

namespace Tests\Controllers;

use SehrGut\Laravel5_Api\Controller;
use SehrGut\Laravel5_Api\Plugins\Authorization;
use Tests\Models\Post;

class AuthorizedController extends Controller
{
    protected $model = Post::class;

    protected $plugins = [
        Authorization::class,
    ];
}
