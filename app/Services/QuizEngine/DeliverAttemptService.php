<?php

namespace App\Services\QuizEngine;

use App\Enums\QuizAttemptStatusEnum;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final readonly class DeliverAttemptService
{
    /**
     * @param QuizAttempt $quizAttempt
     * @return array
     */
    public function handle(QuizAttempt $quizAttempt): Collection
    {
        if ($quizAttempt->status != QuizAttemptStatusEnum::IN_PROGRESS) {
            throw new RuntimeException("This quiz attempt has already been submitted!");
        }

        if (now()->greaterThan($quizAttempt->expires_at)) {
            $quizAttempt->update(['status' => QuizAttemptStatusEnum::EXPIRED]);

            throw new RuntimeException("Attempt expired");
        }

        return DB::transaction(function () use ($quizAttempt) {
            $attempt = QuizAttempt::where('id', $quizAttempt->id)
                ->lockForUpdate()
                ->first();

            $order = $attempt->question_order;

            if (! is_null($order)) {
                return $this->loadOrderedQuestions($order);
            }

            $this->initializeQuestionOrder($attempt);

            return $this->loadOrderedQuestions($attempt->question_order);
        });
    }

    /**
     * @param array $order
     * @return array
     */
    private function loadOrderedQuestions(array $order): Collection
    {
        return Question::whereIn('id', $order)
            ->orderByRaw("FIELD(id, " . implode(',', $order) . ")")
            ->with('questionOptions')
            ->get();
    }

    /**
     * @param QuizAttempt $quizAttempt
     * @param array $questionIds
     * @return void
     */
    private function initializeQuestionOrder(QuizAttempt $quizAttempt): void
    {
        $questionIds = $quizAttempt->quiz
            ->questions()
            ->pluck('id')
            ->toArray();

        shuffle($questionIds);
        $quizAttempt->update(['question_order' => $questionIds]);
    }
}
