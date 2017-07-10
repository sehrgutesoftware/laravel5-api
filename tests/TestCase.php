<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;
use Tests\Migrations\CreateCommentsTable;
use Tests\Migrations\CreatePostsTable;

class TestCase extends BaseTestCase
{
    /**
     * Which controller to use for making requests using `$this->get()` etc…
     *
     * @var Illuminate\Routing\Controller
     */
    public static $controller = \Tests\Controllers\PostsController::class;

    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * Setup DB before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->migrate();
        $this->registerRoutes();
    }

    /**
     * Run test migrations.
     *
     * @return void
     */
    protected function migrate()
    {
        $migrations = [
            CreatePostsTable::class,
            CreateCommentsTable::class,
        ];
        foreach ($migrations as $class) {
            (new $class())->up();
        }
    }

    /**
     * Register all "resource routes" for `PostsController`.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::get('/posts', static::$controller . '@index');
        Route::post('/posts', static::$controller . '@store');
        Route::get('/posts/{id}', static::$controller . '@show');
        Route::put('/posts/{id}', static::$controller . '@update');
        Route::delete('/posts/{id}', static::$controller . '@destroy');
    }
}
