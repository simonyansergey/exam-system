<?php

namespace App\Http\Controllers\Api\V1\QuizAttempt;

use App\Http\Resources\Models\Question\QuestionIndexResource;
use App\Models\QuizAttempt;
use App\Services\QuizEngine\DeliverAttemptService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class QuizAttemptReadController
{
    use AuthorizesRequests;

    /**
     * @param Request $request
     * @param DeliverAttemptService $deliverAttemptService
     * @param QuizAttempt $quizAttempt
     * @return JsonResponse
     */
    public function getQuestions(DeliverAttemptService $deliverAttemptService, QuizAttempt $quizAttempt): JsonResponse
    {
        $this->authorize('view', $quizAttempt);

        return response()->json([
            'quiz_attempt_id' => $quizAttempt->id,
            'expires_at' => $quizAttempt->expires_at,
            'data' => QuestionIndexResource::collection($deliverAttemptService->handle($quizAttempt))
        ]);
    }
}
