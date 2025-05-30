<?php

namespace App\Services\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\UploadedFile;

/**
 * Service for admin question management logic.
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
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
     * Delete a question from the database.
     *
     * @param Question $question
     * @return void
     */
    public function delete(Question $question): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        try {
            $question->delete();
        }
        catch (\Throwable $e) {
            \Log::error('Question deletion failed', [
                'question_id' => $question->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        try {
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
        catch (\Throwable $e) {
            \Log::error('handleQuestionData failed', [
                'data' => $data,
                'existing_question_id' => $existing?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Handle creation or update of a question choice.
     *
     * @param Question $question
     * @param array $choiceData
     * @param int $index
     * @return void
     */
    public function handleChoice(Question $question, array $choiceData, int $index): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        try {
            $choice = $question->choices->get($index);
            $updateData = [
                'choice_text' => $choiceData['choice_text'] ?? null,
                'is_correct' => $index === 0,
            ];

            if (isset($choiceData['choice_image'])) {
                try {
                    $updateData['choice_image'] = $this->uploadFile(
                        $choiceData['choice_image'],
                        'choices'
                    );
                }
                catch (\Throwable $e) {
                    \Log::error('Choice image upload failed', [
                        'question_id' => $question->id,
                        'choice_index' => $index,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
                }

                if ($choice?->choice_image) {
                    try {
                        $this->supabase->deleteImage($choice->choice_image);
                    }
                    catch (\Throwable $e) {
                        \Log::error('Old choice image deletion failed', [
                            'question_id' => $question->id,
                            'choice_index' => $index,
                            'image' => $choice->choice_image,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                        // Not rethrowing, as this is non-critical
                    }
                }
            }

            if ($choice) {
                $choice->update($updateData);
            } else {
                $question->choices()->create($updateData);
            }
        }
        catch (\Throwable $e) {
            \Log::error('handleChoice failed', [
                'question_id' => $question->id,
                'choice_index' => $index,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $filename;
        try {
            $this->supabase->uploadImage($file, $filePath);
        }
        catch (\Throwable $e) {
            \Log::error('File upload to Supabase failed', [
                'file' => $file->getClientOriginalName(),
                'path' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
        return $filePath; // Return relative path for DB storage
    }
}
