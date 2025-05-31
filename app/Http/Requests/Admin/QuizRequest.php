<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for creating or updating a quiz by an admin.
 *
 * @package App\Http\Requests\Admin
 */
class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only allow admins to create/update quizzes.
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'timer' => ['nullable', 'integer'],
            'is_posted' => ['nullable', 'boolean'],
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
            'title.required' => 'The quiz title is required.',
            'title.string' => 'The quiz title must be a string.',
            'timer.integer' => 'The timer must be a number.',
            'is_posted.boolean' => 'The posted status must be true or false.',
        ];
    }

    /**
     * Get the validated data from the request, with is_posted as boolean.
     *
     * @param string|null $key
     * @param mixed $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        // Combine timer_h, timer_m, timer_s into timer (seconds)
        $h = (int) $this->input('timer_h', 0);
        $m = (int) $this->input('timer_m', 0);
        $s = (int) $this->input('timer_s', 0);
        $data['timer'] = ($h * 3600) + ($m * 60) + $s;
        $data['is_posted'] = $this->has('is_posted');
        // Combine timer fields if present
        $data['timer'] = (
            (int) $this->input('timer_h', 0) * 3600 +
            (int) $this->input('timer_m', 0) * 60 +
            (int) $this->input('timer_s', 0)
        );
        return $data;
    }
}
