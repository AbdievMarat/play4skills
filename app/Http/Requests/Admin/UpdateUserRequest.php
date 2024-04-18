<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user')->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'command' => ['nullable', 'array'],
            'mentor_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    $studentRole = Role::query()->where('name', '=', 'student')->first();
                    return $this->input('role_id') == $studentRole->id;
                }),
                Rule::exists('mentors', 'id')
            ],
        ];
    }
}
