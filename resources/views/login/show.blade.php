<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
</head>
<body>
<div class="card">
    <div class="header">
        <span class="title">Login</span>
        <a href="{{ route('register.show') }}" class="category-pill">Register →</a>
    </div>

    @if(session('error'))
        <p class="status-msg">⚠ {{ session('error') }}</p>
    @endif

    @if($errors->any())
        <div class="error-list">
            @foreach($errors->all() as $error)
                <p class="status-msg">⚠ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="form-group">
            <label class="section-label">Email</label>
            <input
                type="email"
                name="email"
                class="letter-input"
                placeholder="john@example.com"
                value="{{ old('email') }}"
                autofocus
            >
        </div>

        <div class="form-group">
            <label class="section-label">Password</label>
            <input
                type="password"
                name="password"
                class="letter-input"
                placeholder="Your password"
            >
        </div>

        <button type="submit" class="guess-btn" style="width:100%; margin-top:1rem;">
            Login
        </button>
    </form>
</div>
</body>
</html>