<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use App\Services\ChallengeGenerator;

class GameController extends Controller
{
    public function __construct(private ChallengeGenerator $challenge) {}

    // MAIN MENU

    public function index()
    {
        $active = auth()->user()->gameSessions()->active()->latest()->get();
        $inactive = auth()->user()->gameSessions()->inactive()->latest()->get();
        // $sessions = session('game_sessions', []);
        return view('game.index', compact('active', 'inactive'));
    }

    public function create()
    {
        return view('game.create');
    }

    public function store()
    {
        auth()->user()->gameSessions()->create([
            'player_name' => request('player_name'),
            'status'      => 'waiting',
        ]);

        return redirect()->route('games.index');
    }

    public function edit($id)
    {
        $session = auth()->user()->gameSessions()->findOrFail($id);
        return view('game.edit', compact('session'));
    }

    public function update($id)
    {
        $session = auth()->user()->gameSessions()->findOrFail($id);
        $session->update([
            'player_name' => request('player_name'),
        ]);
        return redirect()->route('games.index');
    }

    // -------------------------------------------------------
    // HANGMAN
    // -------------------------------------------------------

    public function show()
    {
        $playerId = request('player');
        $gameSession = auth()->user()->gameSessions()->findOrFail($playerId);
        // $sessions = session('game_sessions', []);
        // $session = collect($sessions)->firstWhere('id', (int) $playerId);
        
        // if(!$session){
        //     return redirect()->route('games.index');
        // }

        if ($gameSession->status === 'active' && $gameSession->updated_at->diffInDays(now())>=7){
            $gameSession->markInactive();
            return redirect()->route('games.index')
                ->with('error', 'Session Expired due to inactivity');
        }

        // RESET HANDLING

        if (request()->has('reset')) {
            $isGameOver = $gameSession->mistakes >=6;
            $generated = $this->challenge->generate($isGameOver ? 0 : $gameSession->score);

            $gameSession->update([
                'challenge_id' => $generated['challenge_id'],
                'answer' => $generated['answer'],
                'category' => $generated['category'],
                'mistakes' => $isGameOver ? 0 : $gameSession->mistakes + 1,
                'status' => 'active',
                'is_inactive' => false,
            ]);

            session()->forget('guessedLetters');
            return redirect()->route('games.hangman', ['player' => $playerId]);
        }

        // Start new game if waiting

        if ($gameSession->status === 'waiting'){
            $generated = $this->challenge->generate($gameSession->score);
            $gameSession->update([
                'challenge_id' => $generated['challenge_id'],
                'answer' => $generated['answer'],
                'category' => $generated['category'],
                'status' => 'active',
            ]);
            session()->forget('guessedLetters');
        }

                $message = '';
        if (request()->has('letter')) {
            $message = $this->guess($gameSession);
            $gameSession->refresh();
        }

        $won = $this->isWon($gameSession);

        // mark finished
        if ($won) {
            $gameSession->update([
                'score'       => $gameSession->score + 1,
                'status'      => 'finished',
                'is_inactive' => true,
            ]);
        }

        if ($gameSession->mistakes >= 6) {
            $gameSession->update([
                'status'      => 'finished',
                'is_inactive' => true,
            ]);
        }

        return view('game.hangman', [
            'answer'         => $gameSession->answer,
            'category'       => $gameSession->category,
            'guessedLetters' => session('guessedLetters', []),
            'mistakes'       => $gameSession->mistakes,
            'maxMistakes'    => 6,
            'displayWord'    => $this->getDisplayWord($gameSession),
            'won'            => $won,
            'message'        => $message,
            'player'         => $gameSession->player_name,
            'playerId'       => $playerId,
            'difficulty'     => $this->getDifficulty($gameSession->score),
        ]);
    }
    
    // GUESS

    private function guess(GameSession $gameSession): string
    {
        $letter         = strtoupper(trim(request()->input('letter')));
        $guessedLetters = session('guessedLetters', []);

        if (strlen($letter) !== 1 || !ctype_alpha($letter)) {
            return "Invalid input.";
        }

        if (in_array($letter, $guessedLetters)) {
            return "You already guessed '{$letter}'!";
        }

        $guessedLetters[] = $letter;
        session(['guessedLetters' => $guessedLetters]);

        if (!str_contains($gameSession->answer, $letter)) {
            $gameSession->increment('mistakes');
        }

        return '';
    }

    // GAME STATE

    private function isWon(GameSession $gameSession): bool
    {
        $guessedLetters = session('guessedLetters', []);
        foreach (str_split($gameSession->answer) as $char) {
            if (!in_array($char, $guessedLetters)) return false;
        }
        return true;
    }

    private function getDisplayWord(GameSession $gameSession): string
    {
        $guessedLetters = session('guessedLetters', []);
        $displayWord    = '';
        foreach (str_split($gameSession->answer) as $char) {
            $displayWord .= in_array($char, $guessedLetters) ? $char . ' ' : '_ ';
        }
        return trim($displayWord);
    }

    private function getDifficulty(int $score): string
    {
        if ($score >= 6) return 'hard';
        if ($score >= 3) return 'medium';
        return 'easy';
    }

    public function destroy($id)
    {
        auth()->user()->gameSessions()->findOrFail($id)->delete();
        return redirect()->route('games.index');
    }

}