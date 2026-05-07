<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::query()->withCount('posts')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Category::query()->create($this->validatedData($request));

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berjaya ditambah.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', ['category' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($this->validatedData($request, $category));

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berjaya dikemaskini.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berjaya dipadam.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:20'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($category && $category->exists && $category->slug === $validated['slug']) {
            return $validated;
        }

        $baseSlug = $validated['slug'];
        $counter = 2;

        while (Category::query()->where('slug', $validated['slug'])->when($category, fn ($query) => $query->whereKeyNot($category->id))->exists()) {
            $validated['slug'] = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $validated;
    }
}
