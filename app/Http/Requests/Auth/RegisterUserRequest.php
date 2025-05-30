<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for registering a new user.
 *
 * @package App\Http\Requests\Auth
 */
class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Allow any guest to register.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'in:user,admin'],
            'grade_level' => ['nullable', 'integer', 'between:3,12'],
            'school' => ['nullable', 'string', 'max:255'],
            'coach_name' => ['nullable', 'string', 'max:255'],
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
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'role.required' => 'Role is required.',
            'role.in' => 'Role must be user or admin.',
            'grade_level.integer' => 'Grade level must be a number.',
            'grade_level.between' => 'Grade level must be between 3 and 12.',
        ];
    }
}
