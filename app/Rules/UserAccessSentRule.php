<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserAccessSentRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $access_sent = User::query()
            ->where('email', '=', $value)
            ->where('access_sent', '=', true)
            ->exists();

        if($access_sent){
            $fail('Данному пользователю ранее был отправлен доступ.');
        }
    }
}
