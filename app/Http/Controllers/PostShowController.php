<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class PostShowController extends Controller
{
    public function __invoke(Post $post): View
    {
        $post->load('category');
        $post->increment('views_count');

        return view('post', [
            'post' => $post->refresh()->load('category'),
            'relatedPosts' => Post::query()
                ->with('category')
                ->whereKeyNot($post->id)
                ->where('category_id', $post->category_id)
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'categories' => Category::query()->withCount('posts')->orderBy('name')->get(),
        ]);
    }
}
