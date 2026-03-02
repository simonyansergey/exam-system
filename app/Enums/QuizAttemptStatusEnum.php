<?php

namespace App\Enums;

enum QuizAttemptStatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case SUBMITTED = 'submitted';
    case EXPIRED = 'expired';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
