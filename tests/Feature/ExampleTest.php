<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_search_returns_matching_articles(): void
    {
        $this->seed();

        $response = $this->get('/?q=AI');

        $response
            ->assertStatus(200)
            ->assertSee('Syarikat Tempatan Perkenal Platform AI Untuk Editor Berita');
    }

    public function test_admin_can_login_and_view_posts(): void
    {
        $this->seed();

        $response = $this->post(route('admin.login.store'), [
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        $this->get(route('admin.posts.index'))
            ->assertStatus(200)
            ->assertSee('Artikel');
    }
}
