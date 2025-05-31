<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use App\Models\QuestionChoice;
use App\Services\Admin\QuestionService;
use App\Http\Requests\Admin\QuestionRequest;

/**
 * Controller for managing quiz questions in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class QuestionController
{
    /**
     * The question service instance.
     *
     * @var QuestionService
     */
    protected $service;

    /**
     * Inject QuestionService dependency.
     *
     * @param QuestionService $service
     */
    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of questions for a quiz.
     *
     * @param Quiz $quiz
     * @return \Illuminate\View\View
     */
    public function index(Quiz $quiz)
    {
        try {
            $categories = Category::all();
            $questions = $quiz->questions()->with('choices')->get();

            return view('admin.quizzes.questions', compact('quiz', 'questions', 'categories'));
        }
        catch (\Throwable $e) {
            \Log::error('Admin questions index failed', [
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to load questions. Please try again.');
        }
    }

    /**
     * Store a newly created question in storage.
     *
     * @param QuestionRequest $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request, Quiz $quiz)
    {
        try {
            \Log::info('Question creation started', [
                'quiz_id' => $quiz->id,
                'request_data' => $request->all(),
                'has_file' => $request->hasFile('question_image'),
                'file_valid' => $request->file('question_image')?->isValid(),
            ]);

            $data = $request->validated();
            
            // Handle question image
            if ($request->hasFile('question_image')) {
                $data['question_image'] = $request->file('question_image');
                \Log::info('Question image file details:', [
                    'original_name' => $data['question_image']->getClientOriginalName(),
                    'mime_type' => $data['question_image']->getMimeType(),
                    'size' => $data['question_image']->getSize(),
                ]);
            }

            // Handle choices images
            if ($request->has('choices')) {
                foreach ($request->file('choices', []) as $i => $choiceFiles) {
                    if (isset($choiceFiles['choice_image'])) {
                        $data['choices'][$i]['choice_image'] = $choiceFiles['choice_image'];
                        \Log::info("Choice {$i} image file details:", [
                            'original_name' => $data['choices'][$i]['choice_image']->getClientOriginalName(),
                            'mime_type' => $data['choices'][$i]['choice_image']->getMimeType(),
                            'size' => $data['choices'][$i]['choice_image']->getSize(),
                        ]);
                    }
                }
            }

            // Add quiz_id to data
            $data['quiz_id'] = $quiz->id;

            \Log::info('Final data being sent to service:', [
                'data' => $data,
                'has_question_image' => isset($data['question_image']),
                'choices_count' => count($data['choices'] ?? []),
            ]);

            $question = $this->service->store($data);
            
            \Log::info('Question created successfully:', [
                'question_id' => $question->id,
                'has_image' => !empty($question->question_image),
                'image_path' => $question->question_image,
            ]);

            return redirect()->route('admin.quizzes.questions.index', $quiz)
                ->with('status', 'Question created successfully!');
        }
        catch (\Throwable $e) {
            \Log::error('Question creation failed', [
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create question: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified question in storage.
     *
     * @param QuestionRequest $request
     * @param Quiz $quiz
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionRequest $request, Quiz $quiz, Question $question)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('question_image')) {
                $data['question_image'] = $request->file('question_image');
            }
            // Handle choices images
            if ($request->has('choices')) {
                foreach ($request->file('choices', []) as $i => $choiceFiles) {
                    if (isset($choiceFiles['choice_image'])) {
                        $data['choices'][$i]['choice_image'] = $choiceFiles['choice_image'];
                    }
                }
            }
            $this->service->update($question, $data);
            return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question updated!');
        }
        catch (\Throwable $e) {
            \Log::error('Question update failed', [
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            return back()->withErrors('Failed to update question. Please try again.');
        }
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Quiz $quiz
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        try {
            $this->service->delete($question);
            return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question deleted!');
        }
        catch (\Throwable $e) {
            \Log::error('Question deletion failed', [
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to delete question. Please try again.');
        }
    }
}
