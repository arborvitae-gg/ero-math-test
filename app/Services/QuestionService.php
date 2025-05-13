<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionChoice;

class QuestionService
{
   public function store(array $data): Question
    {
        // Handle question image upload if present
        if (isset($data['question_image']) && $data['question_image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['question_image'] = $data['question_image']->store('questions', 'supabase');
        }

        $question = Question::create([
            'quiz_id' => $data['quiz_id'],
            'category_id' => $data['category_id'],
            'question_text' => $data['question_text'] ?? null,
            'question_image' => $data['question_image'] ?? null,
        ]);

        foreach ($data['choices'] as $index => $choiceData) {
            // Handle choice image upload if present
            if (isset($choiceData['choice_image']) && $choiceData['choice_image'] instanceof \Illuminate\Http\UploadedFile) {
                $choiceData['choice_image'] = $choiceData['choice_image']->store('choices', 'supabase');
            }

            QuestionChoice::create([
                'question_id' => $question->id,
                'choice_text' => $choiceData['choice_text'] ?? null,
                'choice_image' => $choiceData['choice_image'] ?? null,
                'is_correct' => $index == 0,
            ]);
        }

        return $question;
    }


    public function update(Question $question, array $data): Question
    {
        // Handle question image update
        if (isset($data['question_image']) && $data['question_image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['question_image'] = $data['question_image']->store('questions', 'supabase');
        }

        $question->update([
            'question_text' => $data['question_text'] ?? null,
            'question_image' => $data['question_image'] ?? $question->question_image,
        ]);

        foreach ($data['choices'] as $index => $choiceData) {
            $qChoice = $question->choices[$index] ?? null;

            if (isset($choiceData['choice_image']) && $choiceData['choice_image'] instanceof \Illuminate\Http\UploadedFile) {
                $choiceData['choice_image'] = $choiceData['choice_image']->store('choices', 'supabase');
            }

            if ($qChoice) {
                $qChoice->update([
                    'choice_text' => $choiceData['choice_text'] ?? $qChoice->choice_text,
                    'choice_image' => $choiceData['choice_image'] ?? $qChoice->choice_image,
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
