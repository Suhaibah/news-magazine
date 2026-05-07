<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    <style>
        body { align-items: center; background: #f6f4ef; color: #15171a; display: grid; font-family: Arial, Helvetica, sans-serif; min-height: 100vh; margin: 0; }
        .box { background: #fff; border: 1px solid #d9dee5; margin: 0 auto; padding: 24px; width: min(420px, calc(100% - 32px)); }
        h1 { font-family: Georgia, "Times New Roman", serif; font-size: 44px; line-height: .96; margin: 0 0 18px; }
        label { color: #626b76; display: grid; font-size: 13px; font-weight: 700; gap: 6px; text-transform: uppercase; }
        input { border: 1px solid #d9dee5; font: 16px Arial, sans-serif; padding: 10px; width: 100%; }
        button { background: #15171a; border: 0; color: #fff; cursor: pointer; font-weight: 800; margin-top: 14px; padding: 11px 14px; text-transform: uppercase; width: 100%; }
        .error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; margin-bottom: 14px; padding: 10px; }
    </style>
</head>
<body>
    <form class="box" action="{{ route('admin.login.store') }}" method="post">
        @csrf
        <h1>Admin Login</h1>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <label>Password
            <input type="password" name="password" required autofocus>
        </label>
        <button type="submit">Masuk</button>
    </form>
</body>
</html>
