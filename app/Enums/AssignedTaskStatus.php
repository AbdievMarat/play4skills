<?php

namespace App\Enums;

enum AssignedTaskStatus: string
{
    case Performed = 'Выполняется';
    case UnderReview = 'На проверке';
    case Completed = 'Завершена';
    case Revision = 'На доработке';
    case Overdue = 'Просрочена';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }

    public function colorClass(): string
    {
        return match($this) {
            static::Performed => 'bg-warning',
            static::UnderReview => 'bg-primary',
            static::Completed => 'bg-success',
            static::Revision => 'bg-info',
            static::Overdue => 'bg-danger',
        };
    }
}
