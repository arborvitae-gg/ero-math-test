<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'correct_choice_index' => ['required', 'integer', 'between:0,3'],
        ];
    }
}
