<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionConfigsRequest extends FormRequest
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
            'config_ids' => ['array'],
            'config_ids.*' => ['required', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'config_ids.*.required' => 'Поле обязательно к заполнению',
            'config_ids.*.max' => 'Количество символов не может превышать 255',
        ];
    }
}
