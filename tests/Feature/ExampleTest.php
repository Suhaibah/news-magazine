<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
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
        $category = Category::query()->firstOrFail();

        Post::query()->create([
            'category_id' => $category->id,
            'title' => 'Berita AI Malaysia Dari RSS',
            'slug' => 'berita-ai-malaysia-dari-rss',
            'excerpt' => 'Artikel ujian tentang AI.',
            'body' => 'Artikel ujian tentang AI dan teknologi.',
            'author' => 'MetroPress',
            'image_url' => '',
            'views_count' => 100,
            'published_at' => now(),
        ]);

        $response = $this->get('/?q=AI');

        $response
            ->assertStatus(200)
            ->assertSee('Berita AI Malaysia Dari RSS');
    }

    public function test_admin_can_login_and_view_posts(): void
    {
        $this->seed();

        $response = $this->post(route('admin.login.store'), [
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }

    public function test_article_detail_page_increments_views(): void
    {
        $this->seed();
        $category = Category::query()->firstOrFail();

        $post = Post::query()->create([
            'category_id' => $category->id,
            'title' => 'Artikel Detail MetroPress',
            'slug' => 'artikel-detail-metropress',
            'excerpt' => 'Ringkasan artikel detail.',
            'body' => 'Isi artikel detail.',
            'author' => 'MetroPress',
            'image_url' => '',
            'views_count' => 7,
            'published_at' => now(),
        ]);

        $this->get(route('posts.show', $post))
            ->assertStatus(200)
            ->assertSee('Artikel Detail MetroPress');

        $this->assertSame(8, $post->refresh()->views_count);
    }
}
