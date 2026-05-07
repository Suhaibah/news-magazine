<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $latestPost = Post::query()->latest('published_at')->first();
        $latestRssPost = Post::query()->whereNotNull('source_url')->latest('published_at')->first();

        return view('admin.dashboard', [
            'postsCount' => Post::query()->count(),
            'categoriesCount' => Category::query()->count(),
            'rssPostsCount' => Post::query()->whereNotNull('source_url')->count(),
            'postsWithoutImagesCount' => Post::query()
                ->where(function ($query): void {
                    $query->whereNull('image_path')->orWhere('image_path', '');
                })
                ->where(function ($query): void {
                    $query->whereNull('image_url')->orWhere('image_url', '');
                })
                ->count(),
            'latestPost' => $latestPost,
            'latestRssPost' => $latestRssPost,
            'popularPosts' => Post::query()->with('category')->orderByDesc('views_count')->limit(5)->get(),
        ]);
    }
}
