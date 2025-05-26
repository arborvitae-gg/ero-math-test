<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for creating or updating a question by an admin.
 *
 * @package App\Http\Requests\Admin
 */
class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only allow admins to create/update questions.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'question_text' => ['nullable', 'string'],
            'question_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'choices.*.choice_text' => ['nullable', 'string'],
            'choices.*.choice_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * Custom validation error messages for this request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'A category is required for the question.',
            'category_id.exists' => 'The selected category does not exist.',
            'question_image.image' => 'The question image must be a valid image file.',
            'question_image.mimes' => 'The question image must be a jpeg, png, jpg, or gif.',
            'question_image.max' => 'The question image may not be greater than 2MB.',
            'choices.*.choice_image.image' => 'Each choice image must be a valid image file.',
            'choices.*.choice_image.mimes' => 'Each choice image must be a jpeg, png, jpg, or gif.',
            'choices.*.choice_image.max' => 'Each choice image may not be greater than 2MB.',
        ];
    }

    /**
     * Get the validated data from the request, including quiz_id from route.
     *
     * @param string|null $key
     * @param mixed $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['quiz_id'] = $this->route('quiz')?->id; // Pulls from route binding
        return $data;
    }
}
