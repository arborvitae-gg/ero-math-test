<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for starting a quiz attempt (currently no validation rules).
 *
 * @package App\Http\Requests\User
 */
class StartQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only allow authenticated users to start a quiz.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [

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
            // No fields to validate, but you can add custom messages if needed in the future
        ];
    }
}
