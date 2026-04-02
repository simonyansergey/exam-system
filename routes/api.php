<?php

use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptReadController;
use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptWriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->prefix('/quizzes')
    ->group(static function (): void {
        Route::controller(QuizAttemptWriteController::class)
            ->group(static function (): void {
                Route::post('/{quiz}/start', 'startAttempt');
                Route::post('/attempts/{quizAttempt}/answers', 'storeAnswers');
            });

        Route::controller(QuizAttemptReadController::class)
            ->group(static function (): void {
                Route::get('/attempts/{quizAttempt}', 'getQuestions');
            });
    });

require __DIR__ . '/auth.php';
