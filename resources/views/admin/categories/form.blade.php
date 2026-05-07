@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="header-row">
            <h1>{{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
            <a class="button secondary" href="{{ route('admin.categories.index') }}">Kembali</a>
        </div>
        <form class="stack" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="post">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif
            <label>Nama
                <input name="name" value="{{ old('name', $category->name) }}" required>
            </label>
            <label>Deskripsi
                <input name="description" value="{{ old('description', $category->description) }}">
            </label>
            <label>Warna
                <input type="color" name="color" value="{{ old('color', $category->color ?: '#2563eb') }}" required>
            </label>
            <button class="button" type="submit">Simpan</button>
        </form>
    </section>
@endsection
