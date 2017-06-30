<?php

namespace Tests;

use Tests\Classes\Comment;
use Tests\Classes\Post;

class ModelsTest extends TestCase
{
    public function test_it_creates_a_post()
    {
        $this->assertDatabaseMissing('posts', [
            'title' => 'Test Post',
            'slug' => 'test-post'
        ]);

        Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post'
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'slug' => 'test-post'
        ]);
    }

    public function test_it_creates_a_related_comment()
    {
        $post = Post::create(['title' => 'Post 1', 'slug' => 'post-1']);
        $post->comments()->create(['text' => 'Absolutely agree']);

        $this->assertDatabaseHas('comments', [
            'text' => 'Absolutely agree',
            'post_id' => $post->id
        ]);
    }
}
