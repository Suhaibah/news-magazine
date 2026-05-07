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
        .brand { font-family: Georgia, "Times New Roman", serif; font-size: clamp(28px, 5vw, 34px); font-weight: 900; }
        .nav { display: flex; flex-wrap: wrap; gap: 8px; }
        .nav a, .nav button, .button { background: var(--ink); border: 1px solid var(--ink); color: white; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font: 700 12px Arial, sans-serif; min-height: 34px; padding: 8px 11px; text-transform: uppercase; }
        .nav a.secondary, .button.secondary { background: white; color: var(--ink); }
        main { padding: 28px 0 54px; }
        .panel { background: var(--panel); border: 1px solid var(--line); padding: 20px; }
        .header-row { align-items: center; display: flex; gap: 14px; justify-content: space-between; margin-bottom: 18px; }
        h1 { font-family: Georgia, "Times New Roman", serif; font-size: clamp(32px, 5vw, 54px); line-height: .96; margin: 0; }
        h2 { font-family: Georgia, "Times New Roman", serif; font-size: 28px; line-height: 1; margin: 0 0 12px; }
        h3, p { margin: 0; }
        .dashboard-grid { display: grid; gap: 16px; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 18px; }
        .stat { background: #fffdf8; border: 1px solid var(--line); padding: 16px; }
        .stat span { color: var(--muted); display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; }
        .stat strong { display: block; font-family: Georgia, "Times New Roman", serif; font-size: 38px; line-height: 1; margin-top: 8px; }
        .split-grid { display: grid; gap: 18px; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); }
        .tool-panel { background: #fffdf8; border: 1px solid var(--line); padding: 18px; }
        .tool-panel p, .muted { color: var(--muted); }
        .mini-form { align-items: end; display: grid; gap: 10px; grid-template-columns: minmax(0, 1fr) auto; margin-top: 14px; }
        .rank-list { display: grid; gap: 12px; margin-top: 14px; }
        .rank-item { border-top: 1px solid var(--line); display: grid; gap: 8px; grid-template-columns: 42px minmax(0, 1fr); padding-top: 12px; }
        .rank { color: var(--accent); font-family: Georgia, "Times New Roman", serif; font-size: 30px; font-weight: 900; line-height: 1; }
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
        .pagination nav { align-items: center; display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .pagination a, .pagination span { align-items: center; background: #fffdf8; border: 1px solid var(--line); display: inline-flex; font-size: 12px; font-weight: 800; justify-content: center; line-height: 1; min-height: 32px; min-width: 32px; padding: 7px 9px; text-transform: uppercase; }
        .pagination [aria-current="page"] span, .pagination span[aria-current="page"] { background: var(--ink); border-color: var(--ink); color: white; }
        .pagination svg { height: 16px; width: 16px; }
        .pagination .hidden { display: none; }
        @media (max-width: 900px) { .dashboard-grid, .split-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 760px) {
            .masthead, .header-row { align-items: flex-start; flex-direction: column; }
            .nav { width: 100%; }
            .nav a, .nav button, .button { font-size: 11px; min-height: 32px; padding: 7px 9px; }
            table { display: block; overflow-x: auto; }
            .dashboard-grid, .split-grid, .mini-form { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="wrap masthead">
            <a class="brand" href="{{ route('admin.dashboard') }}">MetroPress Admin</a>
            <nav class="nav">
                <a class="secondary" href="{{ route('home') }}">Lihat Website</a>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
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
