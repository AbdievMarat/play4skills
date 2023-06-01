<?php

namespace App\Enums;

enum LessonStatus: string
{
    case Active = 'Отображать';
    case Inactive = 'Не отображать';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
