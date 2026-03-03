<?php

use App\Http\Controllers\Api\V1\QuizAttempt\QuizAttemptWriteController;
use Illuminate\Support\Facades\Route;

Route::post('/quizzes/{quiz}/start', QuizAttemptWriteController::class);
