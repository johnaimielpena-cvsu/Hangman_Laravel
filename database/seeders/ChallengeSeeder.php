<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            // Programming
            ['word' => 'PHP',        'category' => 'Programming', 'difficulty' => 'easy'],
            ['word' => 'Python',     'category' => 'Programming', 'difficulty' => 'easy'],
            ['word' => 'Java',       'category' => 'Programming', 'difficulty' => 'easy'],
            ['word' => 'JavaScript', 'category' => 'Programming', 'difficulty' => 'medium'],
            ['word' => 'Kotlin',        'category' => 'Programming', 'difficulty' => 'medium'],
            ['word' => 'Go',         'category' => 'Programming', 'difficulty' => 'medium'],

            // Frameworks
            ['word' => 'Vue',     'category' => 'Frameworks', 'difficulty' => 'easy'],
            ['word' => 'React',   'category' => 'Frameworks', 'difficulty' => 'easy'],
            ['word' => 'Next',    'category' => 'Frameworks', 'difficulty' => 'easy'],
            ['word' => 'Laravel', 'category' => 'Frameworks', 'difficulty' => 'medium'],
            ['word' => 'Django',  'category' => 'Frameworks', 'difficulty' => 'medium'],

            // Databases
            ['word' => 'PostgreSQL', 'category' => 'Databases', 'difficulty' => 'hard'],
            ['word' => 'MySQL',      'category' => 'Databases', 'difficulty' => 'easy'],
            ['word' => 'MariaDB',    'category' => 'Databases', 'difficulty' => 'medium'],
            ['word' => 'MongoDB',    'category' => 'Databases', 'difficulty' => 'medium'],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }
    }
}