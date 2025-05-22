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
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
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
