<?php

use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptReadController;
use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptWriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->prefix('/quizzes')
    ->group(static function (): void {
        Route::post('/{quiz}/start', QuizAttemptWriteController::class);
        Route::get('/attempts/{quizAttempt}', QuizAttemptReadController::class);
    });

require __DIR__ . '/auth.php';
