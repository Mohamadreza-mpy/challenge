<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_paginated_results()
    {
        $author = Author::factory()
            ->has(Post::factory()
                ->count(20)
                ->has(Comment::factory()->count(5)))
            ->create();

        $response = $this->getJson('/api/v1/posts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => ['current_page', 'total', 'per_page', 'last_page'],
            ])
            ->assertJsonCount(15, 'data');
    }

    #[Test]
    public function it_filters_by_author_id()
    {
        $author = Author::factory()
            ->has(Post::factory()->count(10))
            ->create();

        $response = $this->getJson('/api/v1/posts?author_id=' . $author->id);

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('data.0.author', $author->name);
    }

    #[Test]
    public function it_filters_by_title()
    {
        $author = Author::factory()
            ->has(Post::factory()->count(10))
            ->create();

        $post = $author->posts->first();
        $encodedTitle = urlencode($post->title);

        $response = $this->getJson('/api/v1/posts?title=' . $encodedTitle);

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', $post->title);
    }

    #[Test]
    public function it_validates_query_parameters()
    {
        $response = $this->getJson('/api/v1/posts?author_id=invalid');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['author_id']);

        $response = $this->getJson('/api/v1/posts?per_page=200');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['per_page']);
    }
}
