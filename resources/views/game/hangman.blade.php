<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') . ' - ' . $category }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
    <style>
        input[type='text']{
            width: 100%;
        }
    </style>
</head>
<body>
<div class="card">

    {{-- Header --}}
    <div class="header">
        <span class="title">Hangman</span>
        <div style="display:flex; align-items:center; gap:0.5rem;">
            <span class="category-pill">{{ $category }}</span>
            <span class="status-badge {{ $difficulty }}">{{ $difficulty }}</span>
        </div>
    </div>

    {{-- Lives (hearts) --}}
    <div class="lives-row">
        <span class="lives-label">Lives</span>
        @for($i = 0; $i < $maxMistakes; $i++)
            <span class="heart {{ $i >= ($maxMistakes - $mistakes) ? 'lost' : '' }}">♥</span>
        @endfor
    </div>

    {{-- Word display --}}
    <div class="word-area">
        @foreach(str_split($answer) as $char)
            <div class="letter-slot">
                @if(in_array($char, $guessedLetters))
                    <span class="letter-char reveal">{{ $char }}</span>
                    <div class="letter-bar filled"></div>
                @elseif($mistakes >= $maxMistakes)
                    <span class="letter-char missed">{{ $char }}</span>
                    <div class="letter-bar"></div>
                @else
                    <span class="letter-char">&nbsp;</span>
                    <div class="letter-bar"></div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Status message --}}
    <p class="status-msg">{{ $message ?? '' }}</p>

    {{-- Guessed letters --}}
    @if(count($guessedLetters) > 0)
    <div class="guessed-section">
        <span class="section-label">Guessed</span>
        <div class="guessed-list">
            @foreach($guessedLetters as $gl)
                <span class="gl-chip {{ str_contains($answer, $gl) ? 'correct' : 'wrong' }}">{{ $gl }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Input + Keyboard (only during active game) --}}
    @if(!$won && $mistakes < $maxMistakes)
        <form method="GET" action="{{ route('games.hangman') }}" class="input-row">
            <input type="hidden" name="player" value="{{ $playerId }}">
            <input
                type="text"
                name="letter"
                class="letter-input"
                maxlength="1"
                autocomplete="off"
                autofocus
                placeholder="A"
            >
            {{-- <button type="submit" class="guess-btn">Guess</button> --}}
        </form>

        <div class="keyboard">
            @foreach([['Q','W','E','R','T','Y','U','I','O','P'],['A','S','D','F','G','H','J','K','L'],['Z','X','C','V','B','N','M']] as $row)
            <div class="kb-row">
                @foreach($row as $k)
                    @php
                        $isGuessed = in_array($k, $guessedLetters);
                        $isWrong   = $isGuessed && !str_contains($answer, $k);
                        $isCorrect = $isGuessed && str_contains($answer, $k);
                    @endphp
                    <form method="GET" action="{{ route('games.hangman') }}" class="input-row">
                        <input type="hidden" name="player" value="{{ $playerId }}">
                        <button
                            type="submit"
                            name="letter"
                            value="{{ $k }}"
                            class="key {{ $isWrong ? 'wrong' : ($isCorrect ? 'correct' : '') }}"
                            {{ $isGuessed ? 'disabled' : '' }}
                        >{{ $k }}</button>
                    </form>
                @endforeach
            </div>
            @endforeach
        
    @endif

    {{-- Win / Lose / New Game --}}
    @if($won)
        <div class="result-banner win">
            <span class="result-icon">🎉</span>
            <span class="result-title">You got it!</span>
            <span class="result-sub">The word was</span>
            <span class="result-word">{{ $answer }}</span>
            <a href="{{ route('games.hangman', ['player' => $playerId, 'reset'=>1]) }}"
                 class="play-again-btn">Play Again</a>
        </div>
    {{-- @elseif($mistakes < $maxMistakes && $mistakes > 0)
        <div class="result-banner lose">
            <span class="result-icon">💀</span>
            <span class="result-title">Failed to Answer: Used Skip</span>
            <span class="result-sub">The word was</span>
            <span class="result-word">{{ $answer }}</span>
            <a href="/hangman?reset=1" class="play-again-btn">Try Again</a>
        </div> --}}
    @elseif($mistakes >= $maxMistakes)
        <div class="result-banner lose">
            <span class="result-icon">💀</span>
            <span class="result-title">Game Over: Lifespan drained</span>
            <span class="result-sub">The word was</span>
            <span class="result-word">{{ $answer }}</span>
            <p style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; color:var(--muted); text-align:center;">
                This session is finished. Create a new session to play again.
            </p>
            <a href="{{ route('games.index') }}" class="play-again-btn" style="background:var(--muted); color:#fff;">
                Back to Sessions
            </a>
            <a href="{{ route('games.create') }}" class="play-again-btn">
                New Session
            </a>
        </div>
    @else
        <div class="new-game-link">
            <form method="get" action="{{ route('games.hangman') }}">
                <input type="hidden" name="player" value="{{ $playerId }}">
                <input type="hidden" name="reset" value="1">
                <button type="submit" class="new-game-btn" {{count($guessedLetters) > 0 ? 'disabled': ''}} >New game</a>
                {{-- <p style="color:white">Guessed count: {{ count($guessedLetters) }}</p> --}}
            </form>
        </div>
    
    @endif

    <a class="goBack" href="{{ route('games.index', ['player'=> $playerId]) }}">Go Back</a>
</div>


<script>
    const input = document.querySelector('.letter-input');
    if (input) {
        input.addEventListener('input', function () {
            if (this.value.length === 1 && /[a-zA-Z]/.test(this.value)) {
                this.form.submit();
            }
        });
    }
</script>
</body>
</html>