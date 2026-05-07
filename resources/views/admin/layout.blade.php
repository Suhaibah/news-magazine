<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name') }}</title>
    <style>
        :root { --ink: #15171a; --muted: #626b76; --line: #d9dee5; --paper: #f6f4ef; --panel: #fff; --accent: #c0262d; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: Arial, Helvetica, sans-serif; line-height: 1.5; }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 32px)); margin: 0 auto; }
        .topbar { background: #fffdf8; border-bottom: 1px solid var(--line); }
        .masthead { align-items: center; display: flex; gap: 14px; justify-content: space-between; padding: 16px 0; }
        .brand { font-family: Georgia, "Times New Roman", serif; font-size: 34px; font-weight: 900; }
        .nav { display: flex; flex-wrap: wrap; gap: 8px; }
        .nav a, .nav button, .button { background: var(--ink); border: 1px solid var(--ink); color: white; cursor: pointer; font: 700 13px Arial, sans-serif; padding: 9px 12px; text-transform: uppercase; }
        .nav a.secondary, .button.secondary { background: white; color: var(--ink); }
        main { padding: 28px 0 54px; }
        .panel { background: var(--panel); border: 1px solid var(--line); padding: 20px; }
        .header-row { align-items: center; display: flex; gap: 14px; justify-content: space-between; margin-bottom: 18px; }
        h1 { font-family: Georgia, "Times New Roman", serif; font-size: clamp(32px, 5vw, 54px); line-height: .96; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-top: 1px solid var(--line); padding: 12px; text-align: left; vertical-align: top; }
        th { color: var(--muted); font-size: 12px; text-transform: uppercase; }
        form.stack { display: grid; gap: 14px; }
        label { color: var(--muted); display: grid; font-size: 13px; font-weight: 700; gap: 6px; text-transform: uppercase; }
        input, textarea, select { border: 1px solid var(--line); font: 16px Arial, sans-serif; padding: 10px; width: 100%; }
        textarea { min-height: 130px; resize: vertical; }
        .checkbox { align-items: center; display: flex; gap: 8px; }
        .checkbox input { width: auto; }
        .actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .danger { background: #b91c1c; border-color: #b91c1c; color: white; }
        .status { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; margin-bottom: 16px; padding: 10px; }
        .errors { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; margin-bottom: 16px; padding: 10px; }
        .pagination { margin-top: 18px; }
        @media (max-width: 760px) { .masthead, .header-row { align-items: flex-start; flex-direction: column; } table { display: block; overflow-x: auto; } }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="wrap masthead">
            <a class="brand" href="{{ route('admin.posts.index') }}">MetroPress Admin</a>
            <nav class="nav">
                <a class="secondary" href="{{ route('home') }}">Lihat Website</a>
                <a href="{{ route('admin.posts.index') }}">Artikel</a>
                <a href="{{ route('admin.categories.index') }}">Kategori</a>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="wrap">
        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="errors">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
