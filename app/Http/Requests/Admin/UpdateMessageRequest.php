<?php

namespace App\Http\Requests\Admin;

use App\Enums\MessageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateMessageRequest extends FormRequest
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
            'content' => ['required', 'min:3', 'max:500'],
            'pinned' => ['boolean'],
            'status' => [new Enum(MessageStatus::class)],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'pinned' => filter_var($this->input('pinned'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
