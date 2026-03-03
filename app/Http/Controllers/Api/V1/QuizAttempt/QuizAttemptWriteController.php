<?php

namespace App\Http\Controllers\Api\V1\QuizAttempt;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\QuizEngine\StartAttempt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizAttemptWriteController extends Controller
{
    /**
     * @param Request $request
     * @param StartAttempt $startAttempt
     * @param Quiz $quiz
     * @return Response
     */
    public function __invoke(
        Request $request,
        StartAttempt $startAttempt,
        Quiz $quiz
    ): Response {
        $user = $request->user('sanctum');
        $quizAttempt = $startAttempt->handle($user, $quiz);

        return response()->json([
            'quiz_attempt_id' => $quizAttempt->id,
            'expires_at' => $quizAttempt->expires_at
        ], Response::HTTP_CREATED);
    }
}
