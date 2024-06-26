<?php

namespace App\Http\Requests;

use App\Rules\UserAccessSentRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),
                new UserAccessSentRule
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'У введенной почты нет доступа к участию.',
        ];
    }
}
