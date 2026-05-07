@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="header-row">
            <h1>Artikel</h1>
            <a class="button" href="{{ route('admin.posts.create') }}">Tambah Artikel</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tajuk</th>
                    <th>Kategori</th>
                    <th>Views</th>
                    <th>Publish</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>{{ $post->views_count }}</td>
                        <td>{{ optional($post->published_at)->format('d M Y') }}</td>
                        <td>
                            <div class="actions">
                                <a class="button secondary" href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="post" onsubmit="return confirm('Padam artikel ini?')">
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
        <div class="pagination">{{ $posts->links() }}</div>
    </section>
@endsection
