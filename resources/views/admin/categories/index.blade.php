@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="header-row">
            <h1>Kategori</h1>
            <a class="button" href="{{ route('admin.categories.create') }}">Tambah Kategori</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Artikel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->posts_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="button secondary" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="post" onsubmit="return confirm('Padam kategori ini? Artikel dalam kategori ini juga akan dipadam.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button danger" type="submit">Padam</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
