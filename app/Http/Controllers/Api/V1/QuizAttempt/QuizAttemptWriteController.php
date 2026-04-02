<?php

namespace App\Http\Controllers\Api\V1\QuizAttempt;

use App\Http\Requests\V1\QuizAttempt\QuizAttemptAnswersStoreRequest;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizEngine\StartAttempt;
use App\Services\QuizEngine\StoreAttemptAnswerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class QuizAttemptWriteController
{
    use AuthorizesRequests;

    /**
     * @param Request $request
     * @param StartAttempt $startAttempt
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function startAttempt(
        Request $request,
        StartAttempt $startAttempt,
        Quiz $quiz
    ): JsonResponse {
        $user = $request->user('sanctum');
        $quizAttempt = $startAttempt->handle($user, $quiz);

        return response()->json([
            'quiz_attempt_id' => $quizAttempt->id,
            'expires_at' => $quizAttempt->expires_at
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * @param QuizAttemptAnswersStoreRequest $request
     * @param QuizAttempt $quizAttempt
     * @return JsonResponse
     */
    public function storeAnswers(
        QuizAttemptAnswersStoreRequest $request,
        QuizAttempt $quizAttempt,
        StoreAttemptAnswerService $storeAttemptAnswerService
    ): JsonResponse {
        $this->authorize('answer', $quizAttempt);

        $data = $request->validated();
        $storeAttemptAnswerService->handle($quizAttempt, $data['question_id'], $data['option_id']);

        return response()->json([
            "message" => "Answer stored"
        ], JsonResponse::HTTP_CREATED);
    }
}
