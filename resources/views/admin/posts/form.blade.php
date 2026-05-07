@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="header-row">
            <h1>{{ $post->exists ? 'Edit Artikel' : 'Tambah Artikel' }}</h1>
            <a class="button secondary" href="{{ route('admin.posts.index') }}">Kembali</a>
        </div>
        <form class="stack" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <label>Kategori
                <select name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $post->category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <label>Tajuk
                <input name="title" value="{{ old('title', $post->title) }}" required>
            </label>

            <label>Ringkasan
                <textarea name="excerpt" required>{{ old('excerpt', $post->excerpt) }}</textarea>
            </label>

            <label>Isi Artikel
                <textarea name="body" required>{{ old('body', $post->body) }}</textarea>
            </label>

            <label>Author
                <input name="author" value="{{ old('author', $post->author) }}" required>
            </label>

            <label>Image URL
                <input name="image_url" value="{{ old('image_url', $post->image_url) }}" placeholder="https://...">
            </label>

            <label>Source URL
                <input name="source_url" value="{{ old('source_url', $post->source_url) }}" placeholder="https://...">
            </label>

            <label>Upload Gambar
                <input type="file" name="image" accept="image/*">
            </label>

            <label>Published At
                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\\TH:i')) }}">
            </label>

            <label>Views Count
                <input type="number" min="0" name="views_count" value="{{ old('views_count', $post->views_count ?? 0) }}" required>
            </label>

            <label class="checkbox">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))>
                Artikel Pilihan
            </label>

            <button class="button" type="submit">Simpan</button>
        </form>
    </section>
@endsection
