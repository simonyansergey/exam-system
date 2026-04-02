<?php

namespace App\Http\Controllers\Api\V1\QuizAttempt;

use App\Models\Quiz;
use App\Services\QuizEngine\StartAttempt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class QuizAttemptWriteController
{
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
}
