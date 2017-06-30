<?php

namespace Tests;

use ReflectionClass;
use Illuminate\Http\Request;
use Tests\Classes\Post;
use Tests\Classes\PostsController;

class ControllerRelationsTest extends TestCase
{
    /**
     * Call a controller action and pass through its return value.
     *
     * @param string      $action Controller action (index|show|store|update|destroy)
     * @param array|array $params Request parameters
     *
     * @return Response
     */
    protected function makeRequest($action, $params = [])
    {
        $request = new Request($params);
        $controller = new PostsController($request);

        $reflector_class = new ReflectionClass(PostsController::class);
        $reflector_property = $reflector_class->getProperty('relations');
        $reflector_property->setAccessible(true);
        $reflector_property->setValue($controller, ['comments']);

        return $controller->callAction($action, []);
    }

    public function test_it_includes_relationships()
    {
        $post = Post::create(['title' => 'Some Post', 'slug' => 'some-post']);
        $post->load('comments')->refresh();
        $response = $this->makeRequest('index');
        $this->assertEquals([$post->toArray()],json_decode($response->content(), true));

        $comment = $post->comments()->create(['text' => 'An opinions']);
        $post->load('comments')->refresh();
        $response = $this->makeRequest('index');
        $this->assertEquals([$post->toArray()], json_decode($response->content(), true));
    }
}
