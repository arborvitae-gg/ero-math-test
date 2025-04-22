<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionChoice;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20) as $i) {
            $num1 = rand(1, 20);
            $num2 = rand(1, 20);
            $answer = $num1 + $num2;

            $question = Question::create([
                'category_id' => rand(1, 5),
                'question_type' => 'text',
                'question_content' => "What is $num1 + $num2?",
            ]);

            $correctIndex = rand(0, 3);

            for ($j = 0; $j < 4; $j++) {
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_type' => 'text',
                    'choice_content' => $j == $correctIndex ? $answer : rand(1, 40),
                    'is_correct' => $j == $correctIndex,
                ]);
            }
        }
    }
}
