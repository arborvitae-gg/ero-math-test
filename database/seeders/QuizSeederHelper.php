<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionChoice;

trait QuizSeederHelper
{
    public function seedQuiz($title, $slug = null, $isPosted = false)
    {
        $quiz = Quiz::create([
            'title' => $title,
            'slug' => $slug ?? Str::slug($title),
            'is_posted' => $isPosted,
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
                    'question_text' => "What is $questionText?",
                ]);

                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice_text' => (string)$correctAnswer,
                    'is_correct' => true,
                ]);

                for ($j = 0; $j < 3; $j++) {
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_text' => (string)($correctAnswer + rand(1, 10)),
                        'is_correct' => false,
                    ]);
                }
            }
        }
    }
}
