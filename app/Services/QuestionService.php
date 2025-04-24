<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionChoice;

class QuestionService
{
    public function store(array $data): Question
    {
        $question = Question::create([
            'quiz_id' => $data['quiz_id'],
            'category_id' => $data['category_id'],
            'question_type' => $data['question_type'],
            'question_content' => $data['question_content'],
        ]);

        foreach ($data['choices'] as $index => $choice) {
            QuestionChoice::create([
                'question_id' => $question->id,
                'choice_content' => $choice['choice_content'],
                'choice_type' => $choice['choice_type'],
                'is_correct' => $index == 0,
            ]);
        }

        return $question;
    }

    public function update(Question $question, array $data): Question
    {
        $question->update([
            'question_content' => $data['question_content'],
            'question_type' => $data['question_type'],
        ]);

        foreach ($data['choices'] as $index => $choice) {
            $qChoice = $question->choices[$index] ?? null;

            if ($qChoice) {
                $qChoice->update([
                    'choice_content' => $choice['choice_content'],
                    'choice_type' => $choice['choice_type'],
                    'is_correct' => $index === 0,
                ]);
            }
        }

        return $question;
    }

    public function delete(Question $question): void
    {
        $question->delete();
    }
}
