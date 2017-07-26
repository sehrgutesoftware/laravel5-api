<?php

namespace Tests\Integration\Plugins;

use Tests\Models\Comment;
use Tests\Models\Post;
use Tests\TestCase;

class RelationSplitterPluginTest extends TestCase
{
    /** {@inheritdoc} */
    public static $controller = \Tests\Controllers\RelativesController::class;

    public function test_it_splits_away_direct_relations()
    {
        $post = Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        $comment_1 = Comment::create(['text' => 'An opinion', 'post_id' => $post->id]);
        $comment_2 = Comment::create(['text' => 'Another opinion', 'post_id' => $post->id]);

        $response = $this->get("/posts/$post->id");
        $response->assertJsonStructure([
            'result' => [
                '*' => [],
            ],
            'includes' => [
                'comments' => [
                    '*' => [],
                ],
            ],
        ]);

        $response->assertExactJson([
            'result' => [
                'id'         => 1,
                'publish_at' => null,
                'title'      => 'Test Post',
                'content'    => null,
                'slug'       => 'test-post',
                'created_at' => $post->created_at->toDateTimeString(),
                'updated_at' => $post->updated_at->toDateTimeString(),
                'comments'   => [
                    $comment_1->id,
                    $comment_2->id,
                ],
            ],
            'includes' => [
                'comments' => [
                    [
                        'id'         => $comment_1->id,
                        'text'       => 'An opinion',
                        'post_id'    => "$post->id",
                        'created_at' => $comment_1->created_at->toDateTimeString(),
                        'updated_at' => $comment_1->updated_at->toDateTimeString(),
                    ],
                    [
                        'id'         => $comment_2->id,
                        'text'       => 'Another opinion',
                        'post_id'    => "$post->id",
                        'created_at' => $comment_2->created_at->toDateTimeString(),
                        'updated_at' => $comment_2->updated_at->toDateTimeString(),
                    ],
                ],
            ],
        ]);
    }
}
