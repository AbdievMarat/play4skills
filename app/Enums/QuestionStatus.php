<?php

namespace App\Enums;

enum QuestionStatus: string
{
    case Awaiting = 'На проверке';
    case Incorrect = 'Возвращено на доработку';
    case Yes = 'Ответ принят';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
