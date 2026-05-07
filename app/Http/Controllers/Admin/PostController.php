<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()->with('category')->latest('published_at')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(['published_at' => now()]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        Post::query()->create($data);

        return redirect()->route('admin.posts.index')->with('status', 'Artikel berjaya ditambah.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatedData($request, $post);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'Artikel berjaya dikemaskini.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Artikel berjaya dipadam.');
    }

    private function validatedData(Request $request, ?Post $post = null): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:1000'],
            'body' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'source_url' => ['nullable', 'url', 'max:2048'],
            'image' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'views_count' => ['required', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['image_url'] = $validated['image_url'] ?? '';
        $validated['source_url'] = $validated['source_url'] ?? null;
        $validated['slug'] = Str::slug($validated['title']);
        unset($validated['image']);

        $baseSlug = $validated['slug'];
        $counter = 2;

        while (Post::query()->where('slug', $validated['slug'])->when($post, fn ($query) => $query->whereKeyNot($post->id))->exists()) {
            $validated['slug'] = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $validated;
    }

    private function categories()
    {
        return Category::query()->orderBy('name')->get();
    }
}
