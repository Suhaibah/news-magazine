<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $post->excerpt }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    @if ($post->image_source)
        <meta property="og:image" content="{{ $post->image_source }}">
    @endif
    <title>{{ $post->title }} - {{ config('app.name') }}</title>
    <style>
        :root { --ink: #15171a; --muted: #626b76; --line: #d9dee5; --paper: #f6f4ef; --panel: #fff; --accent: #c0262d; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: Arial, Helvetica, sans-serif; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        img { display: block; height: 100%; object-fit: cover; width: 100%; }
        .wrap { width: min(1080px, calc(100% - 32px)); margin: 0 auto; }
        .topbar { background: #fffdf8; border-bottom: 1px solid var(--line); }
        .masthead { align-items: center; display: flex; justify-content: space-between; gap: 16px; padding: 16px 0; }
        .brand { font-family: Georgia, "Times New Roman", serif; font-size: clamp(34px, 7vw, 58px); font-weight: 900; line-height: .9; }
        .button { background: var(--ink); border: 1px solid var(--ink); color: white; cursor: pointer; display: inline-flex; font: 800 12px Arial, sans-serif; min-height: 34px; padding: 8px 11px; text-transform: uppercase; }
        main { padding: 32px 0 44px; }
        .article-layout { display: grid; gap: 34px; grid-template-columns: minmax(0, 1fr) 280px; }
        .kicker { color: var(--accent); font-size: 13px; font-weight: 900; text-transform: uppercase; }
        h1 { font-family: Georgia, "Times New Roman", serif; font-size: clamp(38px, 7vw, 78px); letter-spacing: 0; line-height: .95; margin: 12px 0 16px; }
        h2 { font-family: Georgia, "Times New Roman", serif; font-size: 28px; line-height: 1; margin: 0 0 14px; }
        p { margin: 0; }
        .excerpt { color: #343941; font-size: 20px; margin-bottom: 18px; }
        .meta { color: var(--muted); font-size: 14px; font-weight: 700; margin: 0 0 18px; }
        .lead-image { aspect-ratio: 16 / 9; border: 1px solid var(--ink); margin: 24px 0; }
        .image-placeholder { align-items: center; background: linear-gradient(135deg, rgba(255,253,248,.9), rgba(246,244,239,.62)), repeating-linear-gradient(135deg, rgba(21,23,26,.08) 0 1px, transparent 1px 12px); display: flex; flex-direction: column; gap: 12px; height: 100%; justify-content: center; padding: 22px; text-align: center; }
        .placeholder-mark { align-items: center; border: 2px solid currentColor; border-radius: 50%; display: inline-flex; font: 900 28px Arial, sans-serif; height: 56px; justify-content: center; width: 56px; }
        .placeholder-title { font-family: Georgia, "Times New Roman", serif; font-size: clamp(22px, 4vw, 38px); font-weight: 900; line-height: 1; max-width: 16ch; }
        .body { background: var(--panel); border-top: 3px solid var(--ink); padding: 22px 0 0; white-space: pre-line; }
        .source-link { color: var(--accent); display: inline-block; font-size: 13px; font-weight: 900; margin-top: 20px; text-transform: uppercase; }
        .side { border-left: 1px solid var(--line); padding-left: 24px; }
        .related { display: grid; gap: 14px; }
        .related article { border-top: 1px solid var(--line); padding-top: 12px; }
        .related h3 { font-family: Georgia, "Times New Roman", serif; font-size: 21px; line-height: 1.08; margin: 6px 0 0; }
        .category-list { display: grid; gap: 8px; margin-top: 24px; }
        .category-list a { align-items: center; background: #fffdf8; border: 1px solid var(--line); display: flex; justify-content: space-between; padding: 10px; }
        @media (max-width: 820px) {
            .masthead { align-items: flex-start; flex-direction: column; }
            .article-layout { grid-template-columns: 1fr; }
            .side { border-left: 0; border-top: 1px solid var(--line); padding: 24px 0 0; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="wrap masthead">
            <a class="brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <a class="button" href="{{ route('home') }}">Kembali</a>
        </div>
    </header>

    <main class="wrap article-layout">
        <article>
            <div class="kicker">{{ $post->category->name }}</div>
            <h1>{{ $post->title }}</h1>
            <p class="excerpt">{{ $post->excerpt }}</p>
            <div class="meta">Oleh {{ $post->author }} - {{ $post->published_at?->format('d M Y, h:i A') }} - {{ number_format($post->views_count) }} views</div>

            <div class="lead-image">
                @if ($post->image_source)
                    <img src="{{ $post->image_source }}" alt="{{ $post->title }}">
                @else
                    <div class="image-placeholder" style="color: {{ $post->category->color }}">
                        <span class="placeholder-mark">{{ mb_substr($post->category->name, 0, 1) }}</span>
                        <span class="placeholder-title">{{ $post->title }}</span>
                    </div>
                @endif
            </div>

            <div class="body">{{ $post->body }}</div>

            @if ($post->source_url)
                <a class="source-link" href="{{ $post->source_url }}" target="_blank" rel="noopener noreferrer">Baca sumber asal</a>
            @endif
        </article>

        <aside class="side">
            <h2>Artikel Berkaitan</h2>
            <div class="related">
                @forelse ($relatedPosts as $relatedPost)
                    <article>
                        <div class="kicker">{{ $relatedPost->category->name }}</div>
                        <h3><a href="{{ route('posts.show', $relatedPost) }}">{{ $relatedPost->title }}</a></h3>
                    </article>
                @empty
                    <p class="meta">Belum ada artikel berkaitan.</p>
                @endforelse
            </div>

            <div class="category-list">
                @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}">
                        <strong>{{ $category->name }}</strong>
                        <span>{{ $category->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </aside>
    </main>
</body>
</html>
