<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionChoice;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                $a = rand(1, 20);
                $b = rand(1, 20);
                $op = ['+', '-', '*'][rand(0, 2)];
                $questionText = "$a $op $b";
                $correctAnswer = eval("return $a $op $b;");

                $question = Question::create([
                    'category_id' => $category->id,
                    'question_type' => 'text',
                    'question_content' => "What is $questionText?",
                ]);

                // First = correct
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_content' => (string)$correctAnswer,
                    'choice_type' => 'text',
                    'is_correct' => true,
                ]);

                // Three wrong answers
                for ($j = 0; $j < 3; $j++) {
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_content' => (string)($correctAnswer + rand(1, 10)),
                        'choice_type' => 'text',
                        'is_correct' => false,
                    ]);
                }
            }
        }
    }
}
