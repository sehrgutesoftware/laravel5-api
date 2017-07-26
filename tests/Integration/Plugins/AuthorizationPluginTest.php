<?php

namespace Tests\Integration\Plugins;

use Illuminate\Support\Facades\Gate;
use SehrGut\Laravel5_Api\Exceptions\Unauthorized;
use Tests\Models\Post;
use Tests\Models\User;
use Tests\TestCase;

class AuthorizationPluginTest extends TestCase
{
    /** {@inheritdoc} */
    public static $controller = \Tests\Controllers\AuthorizedController::class;

    public function test_it_denies_anonymous_access()
    {
        Post::create(['title' => 'Test Post', 'slug' => 'test-post']);

        $response = $this->get('/posts');
        if (!$response->exception instanceof Unauthorized) {
            dd($response->exception);
        }
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->post('/posts');
        if (!$response->exception instanceof Unauthorized) {
            dd($response->exception);
        }
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->get('/posts/1');
        if (!$response->exception instanceof Unauthorized) {
            dd($response->exception);
        }
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->put('/posts/1', ['title' => 'New Title']);
        if (!$response->exception instanceof Unauthorized) {
            dd($response->exception);
        }
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->delete('/posts/1');
        if (!$response->exception instanceof Unauthorized) {
            dd($response->exception);
        }
        $this->assertTrue($response->exception instanceof Unauthorized);
    }

    public function test_it_denies_access_when_no_rules_defined()
    {
        $user = User::create(['email' => 'test@example.org']);
        Post::create(['title' => 'Test Post', 'slug' => 'test-post']);

        $response = $this->actingAs($user)->get('/posts');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->actingAs($user)->post('/posts');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->actingAs($user)->get('/posts/1');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->actingAs($user)->put('/posts/1', ['title' => 'New Title']);
        $this->assertTrue($response->exception instanceof Unauthorized);

        $response = $this->actingAs($user)->delete('/posts/1');
        $this->assertTrue($response->exception instanceof Unauthorized);
    }

    public function test_index_action_with_user()
    {
        $db_user = User::create(['email' => 'test@example.org']);
        Gate::define('index', function ($user, $post) use ($db_user) {
            return $user == $db_user;
        });

        $response = $this->get('/posts');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $this->actingAs($db_user)->get('/posts')
            ->assertStatus(200);
    }

    public function test_store_action_with_user()
    {
        $db_user = User::create(['email' => 'test@example.org']);
        Gate::define('store', function ($user, $post) use ($db_user) {
            return $user == $db_user;
        });

        $response = $this->post('/posts', ['title' => 'Test Post', 'slug' => 'test-post']);
        $this->assertTrue($response->exception instanceof Unauthorized);

        $this->actingAs($db_user)->post('/posts', ['title' => 'Test Post', 'slug' => 'test-post'])
            ->assertStatus(200);
    }

    public function test_show_action_with_user()
    {
        $db_user = User::create(['email' => 'test@example.org']);
        Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        Gate::define('show', function ($user, $post) use ($db_user) {
            return $user == $db_user;
        });

        $response = $this->get('/posts/1');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $this->actingAs($db_user)->get('/posts/1')
            ->assertStatus(200);
    }

    public function test_update_action_with_user()
    {
        $db_user = User::create(['email' => 'test@example.org']);
        Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        Gate::define('update', function ($user, $post) use ($db_user) {
            return $user == $db_user;
        });

        $response = $this->put('/posts/1', ['title' => 'New Title']);
        $this->assertTrue($response->exception instanceof Unauthorized);

        $this->actingAs($db_user)->put('/posts/1', ['title' => 'New Title'])
            ->assertStatus(200);
    }

    public function test_destroy_action_with_user()
    {
        $db_user = User::create(['email' => 'test@example.org']);
        Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        Gate::define('destroy', function ($user, $post) use ($db_user) {
            return $user == $db_user;
        });

        $response = $this->delete('/posts/1');
        $this->assertTrue($response->exception instanceof Unauthorized);

        $this->actingAs($db_user)->delete('/posts/1')
            ->assertStatus(204);
    }
}
