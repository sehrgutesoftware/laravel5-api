<?php

namespace Tests;

use Illuminate\Http\Request;
use Tests\Classes\Post;
use Tests\Classes\PostsController;

class ControllerTest extends TestCase
{
    /**
     * Call a controller action and pass through its return value.
     *
     * @param string      $action Controller action (index|show|store|update|destroy)
     * @param array|array $params Request parameters
     *
     * @return Response
     */
    private function makeRequest(String $action, array $params = [])
    {
        $request = new Request($params);
        $controller = new PostsController($request);

        return $controller->callAction($action, []);
    }

    /**
     * Create some posts in the database.
     *
     * @return array The eloquent model instances for the newly created records
     */
    private function createPosts()
    {
        $posts = [];

        $posts[] = Post::create([
            'title'   => 'Test 1',
            'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
            'slug'    => 'test-1',
        ]);
        $posts[] = Post::create([
            'title'   => 'Test 2',
            'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
            'slug'    => 'test-2',
        ]);
        $posts[] = Post::create([
            'title'   => 'Test 3',
            'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
            'slug'    => 'test-3',
        ]);

        return $posts;
    }

    public function test_it_returns_an_index_of_records()
    {
        $posts = $this->createPosts();
        $response = $this->makeRequest('index');
        $content = $response->content();
        $content_array = json_decode($content, true);

        // Check status code and results count
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(3, count($content_array));

        // Check values of first result
        $this->assertEquals('Test 1', $content_array[0]['title']);
        $this->assertEquals('test-1', $content_array[0]['slug']);
        $this->assertEquals(1, $content_array[0]['id']);

        // Check values of second result
        $this->assertEquals('Test 2', $content_array[1]['title']);
        $this->assertEquals('test-2', $content_array[1]['slug']);
        $this->assertEquals(2, $content_array[1]['id']);

        // Check values of third result
        $this->assertEquals('Test 3', $content_array[2]['title']);
        $this->assertEquals('test-3', $content_array[2]['slug']);
        $this->assertEquals(3, $content_array[2]['id']);
    }

    public function test_it_returns_a_single_record()
    {
        $posts = $this->createPosts();
        $response = $this->makeRequest('show', ['id' => 2]);
        $content = $response->content();
        $content_array = json_decode($content, true);

        // Check status code
        $this->assertEquals(200, $response->getStatusCode());

        // Check values of result
        $this->assertEquals('Test 2', $content_array['title']);
        $this->assertEquals('test-2', $content_array['slug']);
        $this->assertEquals(2, $content_array['id']);
    }

    public function test_it_updates_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3']);

        // Ensure its updated in th db
        $response = $this->makeRequest('update', ['id' => 3, 'title' => 'Test 3-patched']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('posts', ['id' => 3, 'title' => 'Test 3']);
        $this->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3-patched']);

        // Ensure the updated values are returned properly
        $content = $response->content();
        $content_array = json_decode($content, true);
        $this->assertEquals('Test 3-patched', $content_array['title']);
        $this->assertEquals('test-3', $content_array['slug']);
        $this->assertEquals(3, $content_array['id']);
    }

    public function test_it_creates_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3']);
        $this->assertDatabaseMissing('posts', ['title' => 'Test 4']);

        // Ensure the record is persisted properly
        $response = $this->makeRequest('store', ['title' => 'Test 4', 'slug' => 'test-4', 'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('posts', ['id' => 4, 'title' => 'Test 4']);

        // Ensure the new record is returned properly
        $content = $response->content();
        $content_array = json_decode($content, true);
        $this->assertEquals('Test 4', $content_array['title']);
        $this->assertEquals('test-4', $content_array['slug']);
        $this->assertEquals(4, $content_array['id']);
    }

    public function test_it_deletes_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 1]);
        $this->assertDatabaseHas('posts', ['id' => 2]);
        $this->assertDatabaseHas('posts', ['id' => 3]);

        // Ensure the record is deleted
        $response = $this->makeRequest('destroy', ['id' => 2]);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertDatabaseMissing('posts', ['id' => 2]);

        // Ensure the other records are still there
        $this->assertDatabaseHas('posts', ['id' => 1]);
        $this->assertDatabaseHas('posts', ['id' => 3]);

        // Test deleting another one
        $response = $this->makeRequest('destroy', ['id' => 1]);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertDatabaseMissing('posts', ['id' => 1]);
    }
}
