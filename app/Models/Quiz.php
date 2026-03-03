<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'questions_count',
        'max_attempts',
        'pass_score',
        'time_limit_in_minutes',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
