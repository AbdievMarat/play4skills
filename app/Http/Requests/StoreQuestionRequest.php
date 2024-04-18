<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'question_content' => ['required', 'min:3', 'max:1500'],
        ];
    }

    public function messages(): array
    {
        return [
            'question_content.required' => 'Заполните поле вопрос.',
            'question_content.min' => 'Вопрос должен быть не меньше 3 символов.',
            'question_content.max' => 'Вопрос должен быть не больше 1500 символов.',
        ];
    }
}
