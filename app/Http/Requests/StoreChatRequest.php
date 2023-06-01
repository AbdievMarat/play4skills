<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreChatRequest extends FormRequest
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
            'user_id_from' => ['required', Rule::exists('users', 'id')],
            'is_file' => ['required', 'boolean'],
            'content' => [
                Rule::when(function () {
                    return $this->input('is_file') != 1;
                }, ['required', 'string', 'min:3', 'max:255'])
            ],
            'file' => [
                Rule::when(function () {
                    return $this->input('is_file') == 1;
                }, ['required', 'file', File::image()->max(4 * 1024)])
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id_from.required' => 'Выберите получателя.',
            'content.required' => 'Введите сообщение.',
        ];
    }
}
