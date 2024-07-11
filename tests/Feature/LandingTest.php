<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Log in');
        $response->assertSeeText('Register');
    }

    public function test_can_see_articles_on_landing(): void
    {
        Article::create([
            'title' => 'Article title',
            'image_url' => 'awefoiawefub.jpg',
            'body' => 'Article body',
        ]);

        $response = $this->get('/');
        $response->assertSeeText('Article body');

    }
}
