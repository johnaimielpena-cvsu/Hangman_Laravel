<?php

namespace App\Services;

use App\Models\Challenge;

class ChallengeGenerator
{

    

    public function generate(int $score = 0): array
    {
        $difficulty = $this->getDifficulty($score);
        $challenge = Challenge::where('difficulty', $difficulty)
                                ->inRandomOrder()
                                ->first();

        if(!$challenge){
            return $this->fallback();
        }

        return [
            'challenge_id' => $challenge->id,
            'category' => $challenge->category,
            'answer' => strtoupper($challenge->word)
        ];
    }

    public function getDifficulty(int $score): string {
        if ($score >= 6) return 'hard';
        if ($score >=3) return 'medium';
        return 'easy';
    }

    public function fallback(): array
    {
        $words = [
            ['Programming' => ['PHP', 'Python', 'Java', 'JavaScript', 'kotlin', 'Go']],
            ['Frameworks'  => ['Vue', 'React', 'Next', 'Laravel', 'Django']],
            ['Databases'   => ['PostgreSQL', 'MySQL', 'MariaDB', 'MongoDB']]
        ];

        $randomBlock = $words[array_rand($words)];
        $category = array_key_first($randomBlock);
        $answer = strtoupper($randomBlock[$category][array_rand($randomBlock[$category])]);

        return[
            'challenge_id' => null,
            'category' => $category,
            'answer' => $answer
        ];
    }
}