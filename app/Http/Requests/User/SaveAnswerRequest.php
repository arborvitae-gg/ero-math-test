<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

    /**
     * For now, only SaveAnswerRequest is needed. Other operations like start() or submit() don’t involve user input and are controlled by backend logic.

     * Later, if you want to validate quiz title or timer settings from admin, you'd create StoreQuizRequest, UpdateQuizRequest, etc.
     */
class SaveAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'choice_id' => ['nullable', 'exists:question_choices,id'],
            'question_choice_id' => ['nullable'],
        ];
    }
}
