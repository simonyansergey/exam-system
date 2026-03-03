<?php

use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptWriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(static function (): void {
        Route::post('/quizzes/{quiz}/start', QuizAttemptWriteController::class);
    });

require __DIR__ . '/auth.php';
