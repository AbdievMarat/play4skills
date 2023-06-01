<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'avatar' => ['nullable', 'file', File::image()->max(4 * 1024)],
            'command' => ['array'],
            'command.0' => 'required|min:3',
            'command.1' => 'required|min:3',
            'command.2' => 'required|min:3',
            'command.3' => 'nullable|min:3',
            'command.4' => 'nullable|min:3'
        ];
    }

    public function messages()
    {
        return [
            'command.*.required' => 'Поле участник команды обязательно',
            'command.*.min' => 'Поле участник команды должно быть минимум :min символа',
        ];
    }
}
