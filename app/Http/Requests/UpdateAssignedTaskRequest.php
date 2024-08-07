<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateAssignedTaskRequest extends FormRequest
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
            'comment' => ['nullable', 'string', 'max:65535'],
            'attached_file' => ['nullable', 'file', File::image()->max(4 * 1024)],
            'command_member' => ['nullable', 'array'],
            'command_member_name' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'comment.max' => 'Комментарий не должен содержать изображений.',
        ];
    }
}
