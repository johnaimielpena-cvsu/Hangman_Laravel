<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Game Sessions</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
</head>
<body>
<div class="card index-card">

    {{-- Header --}}
    <div class="index-header">
        <span class="title">Sessions</span>
        <div class="index-actions">
            <span class="user-badge">👤 {{ auth()->user()->name }}</span>
            <a href="{{ route('games.create') }}" class="action-btn">+ New</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="action-btn danger">Logout</button>
            </form>
        </div>
    </div>

    {{-- Error message --}}
    @if(session('error'))
        <p class="status-msg">⚠ {{ session('error') }}</p>
    @endif

    {{-- Active Sessions --}}
    <div class="sessions-section">
        <div class="section-header">
            <span class="section-label">Active Sessions</span>
            <span class="section-count">{{ $active->count() }}</span>
        </div>
        <div class="games-list">
            @forelse($active as $session)
                <div class="game-item">
                    <div class="game-info">
                        <span class="game-name">{{ $session->player_name }}</span>
                        <span class="status-badge {{ $session->status }}">{{ $session->status }}</span>
                        <span class="score-pill">{{ $session->score }} pts</span>
                    </div>
                    <div class="game-actions">
                        <a href="{{ route('games.hangman', ['player' => $session->id]) }}" class="action-btn">
                            {{ $session->status === 'waiting' ? 'Start' : 'Continue' }}
                        </a>
                        <form method="POST" action="{{ route('games.destroy', $session->id) }}" style="margin:0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">No active sessions. Create one!</div>
            @endforelse
        </div>
    </div>

    <hr class="divider">

    {{-- Inactive Sessions --}}
    <div class="sessions-section">
        <div class="section-header">
            <span class="section-label">Inactive Sessions</span>
            <span class="section-count">{{ $inactive->count() }}</span>
        </div>
        <div class="games-list">
            @forelse($inactive as $session)
                <div class="game-item inactive">
                    <div class="game-info">
                        <span class="game-name">{{ $session->player_name }}</span>
                        <span class="status-badge finished">{{ $session->status }}</span>
                        <span class="score-pill">{{ $session->score }} pts</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">No inactive sessions yet.</div>
            @endforelse
        </div>
    </div>

</div>
</body>
</html>