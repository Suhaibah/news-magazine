@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="header-row">
            <div>
                <h1>Dashboard</h1>
                <p class="muted">Ringkasan kandungan, RSS, dan artikel popular.</p>
            </div>
            <a class="button" href="{{ route('admin.posts.create') }}">Tambah Artikel</a>
        </div>

        <div class="dashboard-grid">
            <div class="stat">
                <span>Jumlah Artikel</span>
                <strong>{{ number_format($postsCount) }}</strong>
            </div>
            <div class="stat">
                <span>Kategori</span>
                <strong>{{ number_format($categoriesCount) }}</strong>
            </div>
            <div class="stat">
                <span>Artikel RSS</span>
                <strong>{{ number_format($rssPostsCount) }}</strong>
            </div>
            <div class="stat">
                <span>Tanpa Gambar</span>
                <strong>{{ number_format($postsWithoutImagesCount) }}</strong>
            </div>
        </div>

        <div class="split-grid">
            <section class="tool-panel">
                <h2>RSS News</h2>
                <p>Tarik berita terbaru dari semua feed Malaysia yang sudah dikonfigurasi.</p>
                <form class="mini-form" action="{{ route('admin.rss.import') }}" method="post">
                    @csrf
                    <label>
                        Limit setiap feed
                        <input type="number" name="limit" value="10" min="1" max="30">
                    </label>
                    <button class="button" type="submit">Import RSS</button>
                </form>
                <p class="muted" style="margin-top: 12px;">
                    RSS terakhir: {{ $latestRssPost?->published_at?->format('d M Y, h:i A') ?? 'Belum ada' }}
                </p>
            </section>

            <section class="tool-panel">
                <h2>Cleanup</h2>
                <p>Buang artikel RSS lama supaya database kekal ringan.</p>
                <form class="mini-form" action="{{ route('admin.rss.cleanup') }}" method="post" onsubmit="return confirm('Cleanup artikel RSS lama?')">
                    @csrf
                    <label>
                        Simpan artikel terbaru
                        <input type="number" name="keep" value="{{ config('services.news.max_posts', 100) }}" min="10" max="500">
                    </label>
                    <button class="button secondary" type="submit">Cleanup</button>
                </form>
                <p class="muted" style="margin-top: 12px;">
                    Artikel terbaru: {{ $latestPost?->published_at?->format('d M Y, h:i A') ?? 'Belum ada' }}
                </p>
            </section>
        </div>

        <section style="margin-top: 22px;">
            <h2>Popular Sekarang</h2>
            <div class="rank-list">
                @forelse ($popularPosts as $post)
                    <article class="rank-item">
                        <div class="rank">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <strong>{{ $post->title }}</strong>
                            <p class="muted">{{ $post->category->name }} - {{ number_format($post->views_count) }} views</p>
                        </div>
                    </article>
                @empty
                    <p class="muted">Belum ada artikel popular.</p>
                @endforelse
            </div>
        </section>
    </section>
@endsection
