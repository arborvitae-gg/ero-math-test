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
     * Get the validated data from the request, with is_posted as boolean.
     *
     * @param string|null $key
     * @param mixed $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['is_posted'] = $this->has('is_posted');
        return $data;
    }
}
