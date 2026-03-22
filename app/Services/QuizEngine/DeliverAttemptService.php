<?php

namespace App\Services\QuizEngine;

use App\Enums\QuizAttemptStatusEnum;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

final readonly class DeliverAttemptService
{
    /**
     * @param User $user
     * @param QuizAttempt $quizAttempt
     * @return array
     */
    public function handle(
        User $user,
        QuizAttempt $quizAttempt
    ): Collection {
        if ($quizAttempt->status != QuizAttemptStatusEnum::IN_PROGRESS) {
            throw new RuntimeException("This quiz attempt has already been submitted!");
        }

        if (now()->greaterThan($quizAttempt->expires_at)) {
            throw new RuntimeException("This quiz attempt has already been expired!");
        }

        // Should i write this logic inside a policy? I should return 403 forbidden
        if ($user->id != $quizAttempt->user_id) {
            throw new RuntimeException("This quiz attempt has already been expired!");
        }

        $order = $quizAttempt?->question_order;

        if (! is_null($order)) {
            return $this->getQuestions($order);
        }

        $this->shuffleQuestions($quizAttempt);

        return $this->getQuestions($quizAttempt->question_order);
    }

    /**
     * @param array $order
     * @return array
     */
    private function getQuestions(array $order): Collection
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
    private function shuffleQuestions(
        QuizAttempt $quizAttempt
    ): void {
        $questionIds = $quizAttempt->quiz
            ->questions()
            ->pluck('id')
            ->toArray();

        shuffle($questionIds);
        $quizAttempt->update(['question_order' => $questionIds]);
    }
}
