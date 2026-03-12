<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - New Session</title>
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
</head>
<body>
<div class="card">
    <div class="header">
        <span class="title">New Session</span>
        <a href="{{ route('games.index') }}" class="category-pill">← Back</a>
    </div>

    <form method="POST" action="{{ route('games.store') }}">
        @csrf
        <div class="form-group">
            <label class="section-label">Player Name</label>
            <input
                type="text"
                name="player_name"
                class="letter-input"
                style="width:100%; font-size:1rem;"
                placeholder="Enter your name"
                autofocus
            >
        </div>
        <button type="submit" class="guess-btn" style="width:100%; margin-top:1rem;">
            Create Session
        </button>
    </form>
</div>
</body>
</html>