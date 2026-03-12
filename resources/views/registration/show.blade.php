<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
</head>
<body>
<div class="card">
    <div class="header">
        <span class="title">Register</span>
        <a href="{{ route('login.show') }}" class="category-pill">Login →</a>
    </div>

    @if($errors->any())
        <div class="error-list">
            @foreach($errors->all() as $error)
                <p class="status-msg">⚠ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="form-group">
            <label class="section-label">Name</label>
            <input
                type="text"
                name="name"
                class="letter-input"
                placeholder="John Doe"
                value="{{ old('name') }}"
                autofocus
            >
        </div>

        <div class="form-group">
            <label class="section-label">Email</label>
            <input
                type="email"
                name="email"
                class="letter-input"
                placeholder="john@example.com"
                value="{{ old('email') }}"
            >
        </div>

        <div class="form-group">
            <label class="section-label">Password</label>
            <input
                type="password"
                name="password"
                class="letter-input"
                placeholder="Min. 8 characters"
            >
        </div>

        <div class="form-group">
            <label class="section-label">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="letter-input"
                placeholder="Repeat password"
            >
        </div>

        <button type="submit" class="guess-btn" style="width:100%; margin-top:1rem;">
            Create Account
        </button>
    </form>
</div>
</body>
</html>