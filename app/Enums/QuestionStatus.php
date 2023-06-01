<?php

namespace App\Enums;

enum QuestionStatus: string
{
    case Awaiting = 'Ожидает ответа';
    case Incorrect = 'Некорректный вопрос';
    case No = 'Нет';
    case Yes = 'Да';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
