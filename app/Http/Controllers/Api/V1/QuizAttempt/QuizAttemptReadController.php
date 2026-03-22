<?php

namespace App\Http\Controllers\Api\V1\QuizAttempt;

use App\Http\Resources\Models\Question\QuestionIndexResource;
use App\Models\QuizAttempt;
use App\Services\QuizEngine\DeliverAttemptService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class QuizAttemptReadController
{
    /**
     * @param Request $request
     * @param DeliverAttemptService $deliverAttemptService
     * @param QuizAttempt $quizAttempt
     * @return AnonymousResourceCollection
     */
    public function __invoke(
        Request $request,
        DeliverAttemptService $deliverAttemptService,
        QuizAttempt $quizAttempt
    ): AnonymousResourceCollection {

        return QuestionIndexResource::collection(
            $deliverAttemptService->handle(
                user: $request->user('sanctum'),
                quizAttempt: $quizAttempt
            )
        )->additional([
            'quiz_attempt_id' => $quizAttempt->id,
            'expires_at' => $quizAttempt->expires_at
        ]);

    }
}
