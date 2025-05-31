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
        
        \Log::info('Storing question with data:', [
            'data' => $data,
            'has_question_image' => isset($data['question_image']),
            'question_image_type' => isset($data['question_image']) ? get_class($data['question_image']) : null,
        ]);

        return DB::transaction(function () use ($data) {
            $questionData = $this->handleQuestionData($data);
            
            \Log::info('Question data after handling:', [
                'question_data' => $questionData,
                'has_image' => !empty($questionData['question_image']),
            ]);

            $question = Question::create($questionData);

            // Ensure choices is an array
            $choices = $data['choices'] ?? [];
            if (!is_array($choices)) {
                $choices = [];
            }

            \Log::info('Creating choices:', [
                'choices_count' => count($choices),
                'choices_data' => $choices,
            ]);

            // Create choices
            foreach ($choices as $index => $choiceData) {
                $this->handleChoice($question, $choiceData, $index);
            }

            $freshQuestion = $question->fresh(['choices']);
            
            \Log::info('Question created successfully:', [
                'question_id' => $freshQuestion->id,
                'has_image' => !empty($freshQuestion->question_image),
                'image_path' => $freshQuestion->question_image,
            ]);

            return $freshQuestion;
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

            // Ensure choices is an array
            $choices = $data['choices'] ?? [];
            if (!is_array($choices)) {
                $choices = [];
            }

            // Update choices
            foreach ($choices as $index => $choiceData) {
                $this->handleChoice($question, $choiceData, $index);
            }

            return $question->fresh(['choices']); // Reload the question with its choices
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

            // Handle question image upload or removal
            if (!empty($data['remove_question_image']) && $existing?->question_image) {
                $this->supabase->deleteImage($existing->question_image);
                $questionData['question_image'] = null;
            } elseif (isset($data['question_image']) && $data['question_image'] instanceof UploadedFile) {
                try {
                    $questionData['question_image'] = $this->uploadFile(
                        $data['question_image'],
                        'questions'
                    );
                    if ($existing?->question_image) {
                        $this->supabase->deleteImage($existing->question_image);
                    }
                } catch (\Throwable $e) {
                    \Log::error('Question image upload failed', [
                        'data' => $data,
                        'existing_question_id' => $existing?->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
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
            // Get existing choice or create new one
            $choice = $question->choices->get($index) ?? new QuestionChoice();
            
            $updateData = [
                'choice_text' => $choiceData['choice_text'] ?? null,
                'is_correct' => $index === 0,
            ];

            // Handle image upload or removal
            if (!empty($choiceData['remove_choice_image']) && $choice->choice_image) {
                $this->supabase->deleteImage($choice->choice_image);
                $updateData['choice_image'] = null;
            } elseif (isset($choiceData['choice_image']) && $choiceData['choice_image'] instanceof UploadedFile) {
                try {
                    $updateData['choice_image'] = $this->uploadFile(
                        $choiceData['choice_image'],
                        'choices'
                    );
                    if ($choice->choice_image) {
                        $this->supabase->deleteImage($choice->choice_image);
                    }
                } catch (\Throwable $e) {
                    \Log::error('Choice image upload failed', [
                        'question_id' => $question->id,
                        'choice_index' => $index,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
                }
            }

            // Update or create the choice
            if ($choice->exists) {
                $choice->update($updateData);
            } else {
                $updateData['question_id'] = $question->id;
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
