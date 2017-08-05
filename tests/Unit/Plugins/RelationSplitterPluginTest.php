<?php

namespace Tests\Unit\Plugins;

use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Plugins\RelationSplitter;
use Tests\Models\Comment;
use Tests\Models\Post;
use Tests\TestCase;

class RelationSplitterPluginTest extends TestCase
{
    /** {@inheritdoc} */
    public static $controller = \Tests\Controllers\RelativesController::class;

    public function test_it_splits_direct_relations_on_a_single_resource()
    {
        $post = Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        $comment_1 = Comment::create(['text' => 'An opinion', 'post_id' => $post->id]);
        $comment_2 = Comment::create(['text' => 'Another opinion', 'post_id' => $post->id]);
        $comment_1 = $comment_1->fresh();
        $comment_2 = $comment_2->fresh();

        $context = new Context([
            'resource' => Post::with('comments')->find($post->id),
        ]);

        $plugin = new RelationSplitter($context);
        $plugin->formatResource();

        $this->assertEquals($post->id, $context->resource['result']->id);
        $this->assertEquals('Test Post', $context->resource['result']->title);
        $this->assertEquals([$comment_1->id, $comment_2->id], $context->resource['result']->comments->toArray());
        $this->assertEquals([$comment_1, $comment_2], $context->resource['includes']['comments']);
    }

    public function test_it_splits_direct_relations_on_a_collection_of_resources()
    {
        $post_1 = Post::create(['title' => 'Test Post', 'slug' => 'test-post']);
        $post_2 = Post::create(['title' => 'Test Post 2', 'slug' => 'test-post-2']);
        $comment_1 = Comment::create(['text' => 'An opinion', 'post_id' => $post_1->id]);
        $comment_2 = Comment::create(['text' => 'Another opinion', 'post_id' => $post_1->id]);
        $comment_3 = Comment::create(['text' => 'Another opinion', 'post_id' => $post_2->id]);
        $comment_4 = Comment::create(['text' => 'Another opinion', 'post_id' => $post_2->id]);
        $comment_1 = $comment_1->fresh();
        $comment_2 = $comment_2->fresh();
        $comment_3 = $comment_3->fresh();
        $comment_4 = $comment_4->fresh();

        $context = new Context([
            'collection' => Post::with('comments')->get(),
        ]);

        $plugin = new RelationSplitter($context);
        $plugin->formatCollection();

        $this->assertEquals($post_1->id, $context->collection['result'][0]->id);
        $this->assertEquals('Test Post', $context->collection['result'][0]->title);
        $this->assertEquals($post_2->id, $context->collection['result'][1]->id);
        $this->assertEquals('Test Post 2', $context->collection['result'][1]->title);
        $this->assertEquals([$comment_1->id, $comment_2->id], $context->collection['result'][0]->comments->toArray());
        $this->assertEquals([$comment_3->id, $comment_4->id], $context->collection['result'][1]->comments->toArray());
        $this->assertEquals([$comment_1, $comment_2, $comment_3, $comment_4], $context->collection['includes']['comments']);
    }
}
