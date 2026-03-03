<?php

namespace App\Services\QuizEngine;

use App\Enums\QuizAttemptStatusEnum;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final readonly class StartAttempt
{
    /**
     * Undocumented function
     *
     * @param User $user
     * @param Quiz $quiz
     *
     * @throws RuntimeException
     * @return mixed
     */
    public function handle(User $user, Quiz $quiz): QuizAttempt
    {
        if (! $quiz->is_active) {
            throw new RuntimeException("Quiz not active");
        }

        if (! $quiz->time_limit_minutes) {
            throw new RuntimeException("Quiz does not have time limit");
        }

        return DB::transaction(function () use ($user, $quiz) {
            $hasActiveQuizRecord = $quiz->quizAttempts()
                ->where('user_id', $user->id)
                ->where('status', QuizAttemptStatusEnum::IN_PROGRESS)
                ->lockForUpdate()
                ->first();

            if ($hasActiveQuizRecord) {
                throw new RuntimeException("Quiz already started");
            }

            if (! is_null($quiz?->max_attempts)) {
                $attemptCount = $user->quizAttempts()
                    ->where('quiz_id', $quiz->id)
                    ->lockForUpdate()
                    ->count();

                if ($attemptCount >= $quiz->max_attempts) {
                    throw new RuntimeException("Maximum number of attempts exceeded");
                }
            }

            return $user->quizAttempts()->create([
                'quiz_id' => $quiz->id,
                'attempt_uuid' => Str::uuid()->toString(),
                'status' => QuizAttemptStatusEnum::IN_PROGRESS,
                'started_at' => now(),
                'expires_at' => now()->addMinutes($quiz->time_limit_minutes)
            ]);
        });
    }
}
