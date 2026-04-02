<?php

namespace App\Services\QuizEngine;

use App\Enums\QuizAttemptStatusEnum;
use App\Models\AttemptAnswer;
use App\Models\QuestionOption;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StoreAttemptAnswerService
{
    /**
     * @param QuizAttempt $quizAttempt
     * @param integer $questionId
     * @param integer $optionId
     * @return void
     */
    public function handle(QuizAttempt $quizAttempt, int $questionId, int $optionId): void
    {
        if ($quizAttempt->status != QuizAttemptStatusEnum::IN_PROGRESS) {
            throw new RuntimeException("This quiz attempt has already been submitted!");
        }

        if (now()->greaterThan($quizAttempt->expires_at)) {
            $quizAttempt->update(['status' => QuizAttemptStatusEnum::EXPIRED]);

            throw new RuntimeException("Attempt expired");
        }

        if (! in_array($questionId, $quizAttempt->question_order, true)) {
            throw new RuntimeException("The selected question does not exists in this attempt!");
        }

        $optionExists = QuestionOption::where('id', $optionId)
            ->where('question_id', $questionId)
            ->exists();

        if (! $optionExists) {
            throw new RuntimeException("The selected answer option does not exists for this question!");
        }

        DB::transaction(function () use ($quizAttempt, $questionId, $optionId) {
            $quizAttempt = QuizAttempt::where('id', $quizAttempt->id)
                ->lockForUpdate()
                ->first();

            AttemptAnswer::updateOrCreate([
                'quiz_attempt_id' => $quizAttempt->id,
                'question_id' => $questionId
            ], [
                'selected_option_id' => $optionId,
            ]);
        });
    }
}
