<?php

use App\Enums\QuizAttemptStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('quiz_id')->constrained('quizzes');
            $table->string('quiz_attempt_id')->unique();
            $table->enum(
                'status',
                QuizAttemptStatusEnum::values()
            )->default(QuizAttemptStatusEnum::IN_PROGRESS->value);
            $table->timestamp('started_at');
            $table->timestamp('expires_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
