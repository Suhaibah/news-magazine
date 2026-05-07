<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MetroPress ialah demo news magazine Laravel dengan artikel, kategori, carian, trending, dan admin panel.">
    <meta property="og:title" content="{{ config('app.name') }} - News Magazine">
    <meta property="og:description" content="Baca berita nasional, bisnes, teknologi, dan budaya dalam gaya editorial ringkas.">
    <meta property="og:type" content="website">
    @if ($featuredPost)
        <meta property="og:image" content="{{ $featuredPost->image_source }}">
    @endif
    <title>{{ $search ? 'Cari: '.$search.' - ' : '' }}{{ config('app.name') }} - News Magazine</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #15171a;
            --muted: #626b76;
            --line: #d9dee5;
            --paper: #f6f4ef;
            --panel: #ffffff;
            --accent: #c0262d;
            --navy: #1f3a5f;
            --green: #156f5b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .topbar {
            border-bottom: 1px solid var(--line);
            background: #fffdf8;
        }

        .wrap {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .masthead {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 20px;
            padding: 18px 0;
        }

        .date {
            color: var(--muted);
            font-size: 14px;
        }

        .brand {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(34px, 7vw, 72px);
            font-weight: 900;
            letter-spacing: 0;
            text-align: center;
            line-height: .9;
        }

        .edition {
            justify-self: end;
            padding: 8px 12px;
            border: 1px solid var(--ink);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            border-top: 1px solid var(--line);
            padding: 10px 0;
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .nav a.active {
            color: var(--accent);
        }

        .utility-row {
            align-items: center;
            display: grid;
            gap: 12px;
            grid-template-columns: minmax(0, 1fr) auto;
            padding: 16px 0 0;
        }

        .search {
            display: flex;
            gap: 8px;
        }

        .search input {
            background: #fffdf8;
            border: 1px solid var(--line);
            flex: 1;
            font: 16px Arial, Helvetica, sans-serif;
            min-width: 0;
            padding: 10px 12px;
        }

        .button {
            background: var(--ink);
            border: 1px solid var(--ink);
            color: white;
            cursor: pointer;
            font: 800 13px Arial, Helvetica, sans-serif;
            padding: 10px 13px;
            text-transform: uppercase;
        }

        .button.secondary {
            background: #fffdf8;
            color: var(--ink);
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(280px, .65fr);
            gap: 28px;
            padding: 34px 0;
        }

        .lead-image {
            display: block;
            aspect-ratio: 16 / 10;
            border: 1px solid var(--ink);
            background: #ddd;
        }

        .kicker {
            color: var(--accent);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }

        h1, h2, h3, p {
            margin: 0;
        }

        h1 {
            margin-top: 14px;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(34px, 6vw, 68px);
            line-height: .97;
            letter-spacing: 0;
        }

        .lead-copy {
            margin-top: 18px;
            color: #343941;
            font-size: 18px;
        }

        .meta {
            margin-top: 18px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
        }

        .side-panel {
            border-left: 1px solid var(--line);
            padding-left: 28px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .section-title::after {
            content: "";
            height: 1px;
            flex: 1;
            background: var(--line);
        }

        .category-list {
            display: grid;
            gap: 12px;
        }

        .category {
            border: 1px solid var(--line);
            background: var(--panel);
            padding: 14px;
        }

        .category strong {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 16px;
        }

        .dot {
            width: 12px;
            height: 12px;
            flex: 0 0 12px;
            border-radius: 50%;
        }

        .category p {
            margin-top: 6px;
            color: var(--muted);
            font-size: 14px;
        }

        .grid-band {
            border-top: 3px solid var(--ink);
            padding: 28px 0 44px;
        }

        .result-note {
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
            margin: -6px 0 18px;
            text-transform: uppercase;
        }

        .popular-band {
            display: grid;
            grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr);
            gap: 28px;
            border-top: 1px solid var(--line);
            padding: 28px 0 34px;
        }

        .popular-head {
            background: var(--ink);
            color: white;
            min-height: 260px;
            padding: 26px;
        }

        .popular-head span {
            color: #f4b4b8;
            display: block;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .popular-head h2 {
            margin-top: 12px;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(34px, 5vw, 62px);
            line-height: .94;
        }

        .popular-head p {
            margin-top: 16px;
            color: #cbd5e1;
            font-size: 16px;
        }

        .popular-list {
            display: grid;
            gap: 0;
            background: var(--panel);
            border: 1px solid var(--line);
        }

        .popular-item {
            display: grid;
            grid-template-columns: 58px minmax(0, 1fr);
            gap: 14px;
            padding: 16px;
        }

        .popular-item + .popular-item {
            border-top: 1px solid var(--line);
        }

        .rank {
            color: var(--accent);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 42px;
            font-weight: 900;
            line-height: .9;
        }

        .popular-item h3 {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 22px;
            line-height: 1.08;
        }

        .post-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .post-card {
            border-top: 1px solid var(--line);
            padding-top: 16px;
        }

        .thumb {
            display: block;
            aspect-ratio: 4 / 3;
            margin-bottom: 14px;
            background: #ddd;
        }

        .post-card h2 {
            margin-top: 8px;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 25px;
            line-height: 1.05;
            letter-spacing: 0;
        }

        .post-card p {
            margin-top: 10px;
            color: var(--muted);
            font-size: 15px;
        }

        .pagination {
            margin-top: 24px;
        }

        .footer {
            border-top: 1px solid var(--line);
            background: #fffdf8;
            padding: 26px 0 34px;
            color: var(--muted);
            font-size: 14px;
        }

        .footer-grid {
            display: grid;
            gap: 22px;
            grid-template-columns: 1.2fr .8fr .8fr;
        }

        .footer h3 {
            color: var(--ink);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 24px;
            margin: 0 0 8px;
        }

        .footer a {
            display: block;
            margin-top: 7px;
        }

        @media (max-width: 820px) {
            .masthead {
                grid-template-columns: 1fr;
                justify-items: start;
            }

            .brand {
                text-align: left;
            }

            .edition {
                justify-self: start;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .side-panel {
                border-left: 0;
                border-top: 1px solid var(--line);
                padding: 24px 0 0;
            }

            .popular-band {
                grid-template-columns: 1fr;
            }

            .utility-row,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .post-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="wrap">
            <div class="masthead">
                <div class="date">{{ now()->format('l, d F Y') }}</div>
                <a class="brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                <div class="edition">Digital Edition</div>
            </div>
            <nav class="nav" aria-label="Kategori">
                <a class="{{ $currentCategory ? '' : 'active' }}" href="{{ route('home', ['q' => $search ?: null]) }}">Semua</a>
                @foreach ($categories as $category)
                    <a class="{{ $currentCategory === $category->slug ? 'active' : '' }}" href="{{ route('home', ['category' => $category->slug, 'q' => $search ?: null]) }}">{{ $category->name }}</a>
                @endforeach
            </nav>
            <div class="utility-row">
                <form class="search" action="{{ route('home') }}" method="get">
                    @if ($currentCategory)
                        <input type="hidden" name="category" value="{{ $currentCategory }}">
                    @endif
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari tajuk, author, atau topik">
                    <button class="button" type="submit">Cari</button>
                </form>
                <a class="button secondary" href="{{ route('admin.login') }}">Admin</a>
            </div>
        </div>
    </header>

    <main class="wrap">
        @if ($featuredPost)
            <section class="hero">
                <article>
                    <div class="lead-image">
                        <img src="{{ $featuredPost->image_source }}" alt="{{ $featuredPost->title }}">
                    </div>
                    <div class="kicker" style="margin-top: 18px;">{{ $featuredPost->category->name }}</div>
                    <h1>{{ $featuredPost->title }}</h1>
                    <p class="lead-copy">{{ $featuredPost->excerpt }}</p>
                    <div class="meta">Oleh {{ $featuredPost->author }} - {{ $featuredPost->published_at->diffForHumans() }}</div>
                </article>

                <aside class="side-panel">
                    <div class="section-title">Kategori</div>
                    <div class="category-list">
                        @foreach ($categories as $category)
                            <section class="category" id="{{ $category->slug }}">
                                <strong>
                                    <span>{{ $category->name }}</span>
                                    <span class="dot" style="background: {{ $category->color }}"></span>
                                </strong>
                                <p>{{ $category->description }} {{ $category->posts_count }} artikel.</p>
                            </section>
                        @endforeach
                    </div>
                </aside>
            </section>
        @endif

        <section class="popular-band" aria-label="Trending dan popular">
            <div class="popular-head">
                <span>Trending / Popular</span>
                <h2>Yang ramai sedang baca</h2>
                <p>Ringkasan artikel paling menonjol daripada meja editorial MetroPress hari ini.</p>
            </div>

            <div class="popular-list">
                @foreach ($popularPosts as $post)
                    <article class="popular-item">
                        <div class="rank">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <div class="kicker">{{ $post->category->name }}</div>
                            <h3>{{ $post->title }}</h3>
                            <div class="meta">{{ number_format($post->views_count) }} views - {{ $post->published_at->diffForHumans() }}</div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="grid-band">
            <div class="section-title">Berita Terkini</div>
            @if ($search || $currentCategory)
                <div class="result-note">{{ $latestPosts->total() }} artikel dijumpai{{ $search ? ' untuk "'.$search.'"' : '' }}.</div>
            @endif
            <div class="post-grid">
                @forelse ($latestPosts as $post)
                    <article class="post-card">
                        <div class="thumb">
                            <img src="{{ $post->image_source }}" alt="{{ $post->title }}">
                        </div>
                        <div class="kicker">{{ $post->category->name }}</div>
                        <h2>{{ $post->title }}</h2>
                        <p>{{ $post->excerpt }}</p>
                        <div class="meta">Oleh {{ $post->author }} - {{ $post->published_at->format('d M Y') }}</div>
                    </article>
                @empty
                    <p>Tiada artikel dijumpai.</p>
                @endforelse
            </div>
            <div class="pagination">{{ $latestPosts->links() }}</div>
        </section>
    </main>

    <footer class="footer">
        <div class="wrap footer-grid">
            <div>
                <h3>{{ config('app.name') }}</h3>
                <p>Database powered news magazine demo dibina dengan Laravel {{ app()->version() }} dan MySQL XAMPP.</p>
            </div>
            <div>
                <h3>Kategori</h3>
                @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                @endforeach
            </div>
            <div>
                <h3>Hubungi</h3>
                <p>Email: hello@metropress.test</p>
                <p>Admin: <a href="{{ route('admin.login') }}">Masuk panel</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
