<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateTaskRequest extends FormRequest
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
            'description' => ['required', 'max:65535'],
            'file' => ['nullable', 'file', File::image()->max(4 * 1024)],
            'number_of_points' => ['required', 'integer'],
            'number_of_keys' => ['required', 'integer'],
            'important' => ['boolean'],
            'date_deadline' => ['required', 'date'],
            'time_deadline' => ['required', 'date_format:H:i'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'important' => filter_var($this->input('important'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
