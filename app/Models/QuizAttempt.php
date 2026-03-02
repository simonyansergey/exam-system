<?php

namespace App\Models;

use App\Enums\QuizAttemptStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'quiz_attempt_id',
        'status',
        'started_at',
        'expires_at',
        'completed_at',
        'score'
    ];

    protected function casts(): array
    {
        return [
            'status' => QuizAttemptStatusEnum::class
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
