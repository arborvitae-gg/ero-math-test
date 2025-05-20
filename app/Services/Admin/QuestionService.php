<?php

namespace App\Services\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\UploadedFile;

class QuestionService
{
    public function __construct(protected SupabaseService $supabase) {}

    public function store(array $data): Question
    {
        return DB::transaction(function () use ($data) {
            $questionData = $this->handleQuestionData($data);
            $question = Question::create($questionData);

            foreach ($data['choices'] as $index => $choiceData) {
                $this->handleChoice($question, $choiceData, $index);
            }

            return $question;
        });
    }

    public function update(Question $question, array $data): Question
    {
        return DB::transaction(function () use ($question, $data) {
            $questionData = $this->handleQuestionData($data, $question);
            $question->update($questionData);

            foreach ($data['choices'] as $index => $choiceData) {
                $this->handleChoice($question, $choiceData, $index);
            }

            return $question;
        });
    }

    private function handleQuestionData(array $data, ?Question $existing = null): array
    {
        $questionData = [
            'quiz_id' => $data['quiz_id'],
            'category_id' => $data['category_id'],
            'question_text' => $data['question_text'] ?? null,
        ];

        if (isset($data['question_image'])) {
            $questionData['question_image'] = $this->uploadFile(
                $data['question_image'],
                'questions'
            );

            if ($existing?->question_image) {
                $this->supabase->deleteImage($existing->question_image);
            }
        }

        return $questionData;
    }

    private function handleChoice(Question $question, array $choiceData, int $index): void
    {
        $choice = $question->choices->get($index);
        $updateData = [
            'choice_text' => $choiceData['choice_text'] ?? null,
            'is_correct' => $index === 0,
        ];

        if (isset($choiceData['choice_image'])) {
            $updateData['choice_image'] = $this->uploadFile(
                $choiceData['choice_image'],
                'choices'
            );

            if ($choice?->choice_image) {
                $this->supabase->deleteImage($choice->choice_image);
            }
        }

        if ($choice) {
            $choice->update($updateData);
        } else {
            $question->choices()->create($updateData);
        }
    }

    public function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $filename;

        // Only upload the file, don't return the full URL
        $this->supabase->uploadImage($file, $filePath);

        return $filePath; // Return relative path for DB storage
    }


    public function delete(Question $question): void
    {
        $question->delete();
    }
}
