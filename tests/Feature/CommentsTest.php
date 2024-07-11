<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_creation_form_visibility(): void
    {
        $article = Article::factory()->create();

        $response = $this->get('/post/'.$article->id);

        $response->assertStatus(200);

        $response->assertSee(route('comment.store', $article));
        $response->assertSeeText('New comment');
        $response->assertSeeText('Author');
        $response->assertSeeText('Body');
    }

    public function test_comment_creation(): void
    {
        $article = Article::factory()->create();

        $response = $this->post("/post/$article->id/comment", [
            'author' => 'Testa autors',
            'body' => 'Testa komentārs',
        ]);

        $response->assertRedirect(route('landing.article', $article));

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'author' => 'Testa autors',
            'body' => 'Testa komentārs',
        ]);

    }

    public function test_comment_visibility(): void
    {
        $article = Article::factory()
            ->has(Comment::factory()->count(3))
            ->create();

        $comment = $article->comments()->first();

        $response = $this->get(route('landing.article', $article->id));

        $response->assertSeeText($comment->author);
        $response->assertSeeText($comment->body);
    }

    public function test_comment_creation_form_author_autofill(): void
    {
        $user = User::factory()->create();

        $article = Article::create([
            'title' => 'Article title is at least 15 character long',
            'image_url' => '',
            'body' => 'Article body',
        ]);

        $response = $this->actingAs($user)->get('/post/'.$article->id);

        $response->assertStatus(200);

        $response->assertSee('value="'.$user->name.'"', false);
    }
}
