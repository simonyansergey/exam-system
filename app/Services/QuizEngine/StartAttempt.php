<?php

namespace App\Services\QuizEngine;

use App\Enums\QuizAttemptStatusEnum;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;

final readonly class StartAttempt
{
    /**
     * Undocumented function
     *
     * @param User $user
     * @param Quiz $quiz
     *
     * @throws Exception
     * @return mixed
     */
    public function save(User $user, Quiz $quiz): QuizAttempt
    {
        if (! $quiz->is_active) {
            throw new Exception("Quiz not active");
        }

        $hasActiveQuizRecord = $quiz->quizAttempts()
            ->where('user_id', $user->id)
            ->where('status', QuizAttemptStatusEnum::IN_PROGRESS)
            ->exists();

        if ($hasActiveQuizRecord) {
            throw new Exception("Quiz already started");
        }

        if ($user->quizAttempts()->where('quiz_id', $quiz->id)->count() >= $quiz->max_attempts) {
            throw new Exception("Maximum number of attempts exceeded");
        }

        return $user->quizAttempts()->create([
            'quiz_id' => $quiz->id,
            'attempt_uuid' => Str::uuid()->toString(),
            'status' => QuizAttemptStatusEnum::IN_PROGRESS,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($quiz->time_limit_minutes)
        ]);
    }
}
