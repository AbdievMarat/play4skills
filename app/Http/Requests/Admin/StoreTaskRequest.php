<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreTaskRequest extends FormRequest
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
            'description' => ['required'],
            'file' => ['nullable', File::image()->max(2 * 1024)],
            'number_of_points' => ['required', 'integer'],
            'number_of_keys' => ['required', 'integer'],
            'date_deadline' => ['required', 'date', 'after:today'],
        ];
    }
}
