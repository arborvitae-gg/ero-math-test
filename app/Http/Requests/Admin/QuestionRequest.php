<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'question_text' => ['nullable', 'string'],
            'question_image' => ['nullable', 'image', 'max:2048'],
            'choices.*.choice_text' => ['nullable', 'string'],
            'choices.*.choice_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['quiz_id'] = $this->route('quiz')?->id; // Pulls from route binding
        return $data;
    }
}
