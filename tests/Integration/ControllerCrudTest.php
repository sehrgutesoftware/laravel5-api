<?php

namespace Tests\Integration;

use Tests\TestCase;
use Tests\Models\Post;

class ControllerCrudTest extends TestCase
{
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

        $response = $this->get('/posts')
            ->assertStatus(200)
            ->assertJson([
                [
                    'id'    => '1',
                    'title' => 'Test 1',
                    'slug'  => 'test-1',
                ],
                [
                    'id'    => '2',
                    'title' => 'Test 2',
                    'slug'  => 'test-2',
                ],
                [
                    'id'    => '3',
                    'title' => 'Test 3',
                    'slug'  => 'test-3',
                ],
            ]);
    }

    public function test_it_returns_a_single_record()
    {
        $posts = $this->createPosts();

        $this->get('/posts/2')
            ->assertStatus(200)
            ->assertExactJson([
                'id'         => 2,
                'title'      => 'Test 2',
                'slug'       => 'test-2',
                'content'    => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
                'created_at' => $posts[1]->created_at->toDateTimeString(),
                'updated_at' => $posts[1]->updated_at->toDateTimeString(),
                'publish_at' => null,
            ]);
    }

    public function test_it_updates_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3']);

        // Ensure the new values are returned properly
        $this->put('/posts/3', ['title' => 'Test 3-patched'])
            ->assertStatus(200)
            ->assertJson([
                'title' => 'Test 3-patched',
            ]);

        // Ensure its updated properly in db
        $this->assertDatabaseMissing('posts', ['id' => 3, 'title' => 'Test 3'])
            ->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3-patched']);
    }

    public function test_it_creates_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 3, 'title' => 'Test 3']);
        $this->assertDatabaseMissing('posts', ['title' => 'Test 4']);

        // Ensure the new record is returned properly
        $this->post('/posts', [
            'title'   => 'Test 4',
            'slug'    => 'test-4',
            'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
        ])
            ->assertStatus(200)
            ->assertJson([
                'id'      => 4,
                'title'   => 'Test 4',
                'slug'    => 'test-4',
                'content' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.',
            ]);

        // Ensure the record is persisted properly
        $this->assertDatabaseHas('posts', ['id' => 4, 'title' => 'Test 4']);
    }

    public function test_it_deletes_a_record()
    {
        $posts = $this->createPosts();
        $this->assertDatabaseHas('posts', ['id' => 1]);
        $this->assertDatabaseHas('posts', ['id' => 2]);
        $this->assertDatabaseHas('posts', ['id' => 3]);

        $this->delete('/posts/2')
            ->assertStatus(204);

        // Ensure the record is deleted
        $this->assertDatabaseMissing('posts', ['id' => 2]);

        // Ensure the other records are still there
        $this->assertDatabaseHas('posts', ['id' => 1]);
        $this->assertDatabaseHas('posts', ['id' => 3]);

        // Test deleting another one
        $this->delete('/posts/1');
        $this->assertDatabaseMissing('posts', ['id' => 1]);
    }
}
