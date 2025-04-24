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
            'question_type' => ['required', 'in:text,image'],
            'question_content' => ['required', 'string'],
            'choices.*.choice_content' => ['required', 'string'],
            'choices.*.choice_type' => ['required', 'in:text,image'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['quiz_id'] = $this->route('quiz')?->id; // Pulls from route binding
        return $data;
    }
}
