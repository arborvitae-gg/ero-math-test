<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionChoice;


class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'Math Quiz 2025',
            'slug' => Str::slug('Math Quiz 2025'), // explicitly added in case seeding bypasses model events
            'is_posted' => false,
        ]);

        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                $a = rand(1, 20);
                $b = rand(1, 20);
                $op = ['+', '-', '*'][rand(0, 2)];
                $questionText = "$a $op $b";
                $correctAnswer = eval("return $a $op $b;");

                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'category_id' => $category->id,
                    'question_type' => 'text',
                    'question_content' => "What is $questionText?",
                ]);

                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_content' => (string)$correctAnswer,
                    'choice_type' => 'text',
                    'is_correct' => true,
                ]);

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
