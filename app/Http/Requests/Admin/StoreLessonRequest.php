<?php

namespace App\Http\Requests\Admin;

use App\Enums\LessonStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class StoreLessonRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255'],
            'link' => ['required', 'url', 'regex:/https:\/\/www\.youtube\.com\/embed/'],
            'content' => ['required'],
            'status' => [new Enum(LessonStatus::class)],
        ];
    }

    public function messages()
    {
        return [
            'link.regex' => 'Введите правильный URL-адрес видео YouTube, в формате https://www.youtube.com/embed/8pSGLxi8-FU.',
        ];
    }
}
