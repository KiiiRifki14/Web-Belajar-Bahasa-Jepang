<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Level;
use App\Models\Question;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Region
        $region = Region::create([
            'name' => 'Desa Hajime',
            'order' => 1,
            'description' => 'The beginning of your odyssey. Learn basic Hiragana and greetings.'
        ]);

        // 2. Create Levels
        $level1 = Level::create([
            'region_id' => $region->id,
            'name' => 'Hiragana: A-I-U-E-O',
            'order' => 1,
            'is_boss_level' => false,
            'required_streak' => 0
        ]);

        $level2 = Level::create([
            'region_id' => $region->id,
            'name' => 'Basic Greetings',
            'order' => 2,
            'is_boss_level' => false,
            'required_streak' => 0
        ]);

        // 3. Create Questions for Level 1
        $questionsL1 = [
            [
                'type' => 'multiple_choice',
                'difficulty' => 1,
                'question_text' => 'What is the reading for "あ"?',
                'options' => ['A' => 'a', 'B' => 'i', 'C' => 'u', 'D' => 'e'],
                'correct_answer' => 'a',
                'explanation' => 'あ is the first character in Hiragana, read as "a".'
            ],
            [
                'type' => 'multiple_choice',
                'difficulty' => 1,
                'question_text' => 'What is the reading for "い"?',
                'options' => ['A' => 'u', 'B' => 'e', 'C' => 'i', 'D' => 'o'],
                'correct_answer' => 'i',
                'explanation' => 'い is read as "i".'
            ],
            [
                'type' => 'fill_in',
                'difficulty' => 2,
                'question_text' => 'Type the reading for "う"',
                'correct_answer' => 'u',
                'explanation' => 'う is read as "u".'
            ],
            [
                'type' => 'multiple_choice',
                'difficulty' => 1,
                'question_text' => 'What is the reading for "え"?',
                'options' => ['A' => 'o', 'B' => 'e', 'C' => 'a', 'D' => 'u'],
                'correct_answer' => 'e',
                'explanation' => 'え is read as "e".'
            ],
            [
                'type' => 'multiple_choice',
                'difficulty' => 2,
                'question_text' => 'Which character is "o"?',
                'options' => ['A' => 'あ', 'B' => 'い', 'C' => 'う', 'D' => 'お'],
                'correct_answer' => 'お',
                'explanation' => 'お is read as "o".'
            ],
        ];

        foreach ($questionsL1 as $q) {
            Question::create(array_merge($q, ['level_id' => $level1->id]));
        }

        // 4. Create Questions for Level 2
        $questionsL2 = [
            [
                'type' => 'multiple_choice',
                'difficulty' => 1,
                'question_text' => 'How do you say "Good Morning"?',
                'options' => ['A' => 'Arigatou', 'B' => 'Ohayou', 'C' => 'Sayonara', 'D' => 'Sumimasen'],
                'correct_answer' => 'Ohayou',
                'explanation' => 'Ohayou gozaimasu means Good Morning.'
            ],
            [
                'type' => 'fill_in',
                'difficulty' => 2,
                'question_text' => 'Type "Hello" in Japanese (Romaji)',
                'correct_answer' => 'Konnichiwa',
                'explanation' => 'Konnichiwa is a common greeting for "Hello" or "Good Day".'
            ],
        ];

        foreach ($questionsL2 as $q) {
            Question::create(array_merge($q, ['level_id' => $level2->id]));
        }
    }
}
