<?php

namespace Tests\Integration;

use Tests\Models\Post;
use Tests\TestCase;

class ControllerRelationsTest extends TestCase
{
    /** {@inheritdoc} */
    public static $controller = \Tests\Controllers\PostsWithCommentsController::class;

    public function test_it_includes_relationships_on_show()
    {
        $post = Post::create(['title' => 'Some Post', 'slug' => 'some-post']);

        // First, there shouldn't be any comments…
        $this->get('/posts/'.$post->id)
            ->assertJson([
                'id'       => $post->id,
                'comments' => [],
            ]);

        $comment = $post->comments()->create(['text' => 'An opinion on this…']);

        // …but after inserting one, it should appear
        $this->get('/posts/'.$post->id)
            ->assertJson([
                'id'       => $post->id,
                'comments_count' => 1,
                'comments' => [
                    [
                        'id'   => $comment->id,
                        'text' => 'An opinion on this…',
                    ],
                ],
            ]);
    }

    public function test_it_includes_relationships_on_index()
    {
        $post = Post::create(['title' => 'Some Post', 'slug' => 'some-post']);

        // First, there shouldn't be any comments…
        $this->get('/posts')
            ->assertJson([[
                'id'       => $post->id,
                'comments' => [],
            ]]);

        $comment_1 = $post->comments()->create(['text' => 'An opinion on this…']);
        $comment_2 = $post->comments()->create(['text' => 'Some more rant…']);

        // …but after inserting some, they should appear
        $this->get('/posts')
            ->assertJson([[
                'id'       => $post->id,
                'comments' => [
                    [
                        'id'   => $comment_1->id,
                        'text' => 'An opinion on this…',
                    ],
                    [
                        'id'   => $comment_2->id,
                        'text' => 'Some more rant…',
                    ],
                ],
            ]]);
    }
}
