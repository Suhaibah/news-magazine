<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $categorySlug = $request->query('category');

        $featuredPost = Post::query()
            ->with('category')
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        $latestPosts = Post::query()
            ->with('category')
            ->when($featuredPost && $search === '' && ! $categorySlug, fn ($query) => $query->whereKeyNot($featuredPost->id))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, fn ($query) => $query->whereHas('category', fn ($query) => $query->where('slug', $categorySlug)))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $popularPosts = Post::query()
            ->with('category')
            ->orderByDesc('views_count')
            ->latest('published_at')
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        return view('home', [
            'featuredPost' => $featuredPost,
            'latestPosts' => $latestPosts,
            'popularPosts' => $popularPosts,
            'categories' => $categories,
            'search' => $search,
            'currentCategory' => $categorySlug,
        ]);
    }
}
