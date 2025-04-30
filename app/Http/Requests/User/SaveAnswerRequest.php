<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

    /**
     * For now, only SaveAnswerRequest is needed. Other operations like start() or submit() don’t involve user input and are controlled by backend logic.

     * Later, if you want to validate quiz title or timer settings from admin, you'd create StoreQuizRequest, UpdateQuizRequest, etc.
     */
class SaveAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'choice_id' => ['required', 'exists:question_choices,id'],
            'choice_order' => ['nullable', 'array'], // to store shuffled order
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Optionally decode choice_order if passed as string
        if (is_string($data['choice_order'] ?? null)) {
            $data['choice_order'] = json_decode($data['choice_order'], true);
        }

        return $data;
    }
}
