<?php

namespace App\Services\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\UploadedFile;

/**
 * Service for admin question management logic, including image handling.
 *
 * @package App\Services\Admin
 */
class QuestionService
{
    public function __construct(protected SupabaseService $supabase) {}

    /**
     * Store a new question and its choices.
     *
     * @param array $data
     * @return Question
     */
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

    /**
     * Update an existing question and its choices.
     *
     * @param Question $question
     * @param array $data
     * @return Question
     */
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

    /**
     * Prepare question data for storage or update.
     *
     * @param array $data
     * @param Question|null $existing
     * @return array
     */
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

    /**
     * Handle creation or update of a question choice.
     *
     * @param Question $question
     * @param array $choiceData
     * @param int $index
     * @return void
     */
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

    /**
     * Upload a file to Supabase and return its relative path.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $filename;

        // Only upload the file, don't return the full URL
        $this->supabase->uploadImage($file, $filePath);

        return $filePath; // Return relative path for DB storage
    }

    /**
     * Delete a question from the database.
     *
     * @param Question $question
     * @return void
     */
    public function delete(Question $question): void
    {
        $question->delete();
    }
}
