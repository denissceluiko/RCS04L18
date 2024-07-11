<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_creation(): void
    {
        $user = User::factory()->create();

        $response = $this
        ->actingAs($user)
        ->post('/article', [
            'title' => 'Article title is at least 15 character long',
            'body' => 'Article body',
        ]);

        $this->assertDatabaseCount('articles', 1);
        $response->assertStatus(302);

        $response = $this->get('/');
        $response->assertSeeText('Article title is at least 15 character long');
    }

    public function test_cant_create_article_without_logging_in(): void
    {
        $response = $this->post('/article', [
            'title' => 'Article title',
            'body' => 'Article body',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_article_update(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $response = $this
        ->actingAs($user)
        ->put('/article/'.$article->id, [
            'title' => 'Article title is updated and is at least 15 character long',
            'body' => 'Article body is updated',
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Article title is updated and is at least 15 character long',
            'image_url' => $article->image_url,
            'body' => 'Article body is updated',
        ]);

        $response->assertRedirect(route('article.index'));
    }

    public function test_article_deletion(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $response = $this
        ->actingAs($user)
        ->delete('/article/'.$article->id);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'body' => $article->body,
        ]);

        $response->assertRedirect(route('article.index'));
    }
}
