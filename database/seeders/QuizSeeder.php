<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'PHP & Laravel Fundamentals',
            'description' => 'Test your knowledge of core PHP and Laravel concepts.',
            'questions_count' => 5,
            'max_attempts' => 3,
            'pass_score' => 80,
            'time_limit_in_minutes' => 20,
        ]);

        $q1 = $quiz->questions()->create([
            'text' => 'What does MVC stand for?',
            'type' => QuestionTypeEnum::MCQ,
        ]);

        $q1->questionOptions()->createMany([
            ['text' => 'Model View Controller', 'is_correct' => true],
            ['text' => 'Main View Control', 'is_correct' => false],
            ['text' => 'Model Version Control', 'is_correct' => false],
            ['text' => 'Module View Component', 'is_correct' => false],
        ]);

        $q2 = $quiz->questions()->create([
            'text' => 'Which Artisan command creates a new controller?',
            'type' => QuestionTypeEnum::MCQ,
        ]);

        $q2->questionOptions()->createMany([
            ['text' => 'php artisan make:controller', 'is_correct' => true],
            ['text' => 'php artisan new:controller', 'is_correct' => false],
            ['text' => 'php artisan controller:create', 'is_correct' => false],
            ['text' => 'php artisan build:controller', 'is_correct' => false],
        ]);

        $q3 = $quiz->questions()->create([
            'text' => 'Which file defines API routes in Laravel?',
            'type' => QuestionTypeEnum::MCQ,
        ]);

        $q3->questionOptions()->createMany([
            ['text' => 'routes/api.php', 'is_correct' => true],
            ['text' => 'routes/web.php', 'is_correct' => false],
            ['text' => 'app/Http/api.php', 'is_correct' => false],
            ['text' => 'config/routes.php', 'is_correct' => false],
        ]);

        $q4 = $quiz->questions()->create([
            'text' => 'Which method is used to define a one-to-many relationship?',
            'type' => QuestionTypeEnum::MCQ,
        ]);

        $q4->questionOptions()->createMany([
            ['text' => 'hasMany()', 'is_correct' => true],
            ['text' => 'belongsTo()', 'is_correct' => false],
            ['text' => 'hasOne()', 'is_correct' => false],
            ['text' => 'morphTo()', 'is_correct' => false],
        ]);

        $q5 = $quiz->questions()->create([
            'text' => 'What is used in Laravel to handle background jobs?',
            'type' => QuestionTypeEnum::MCQ,
        ]);

        $q5->questionOptions()->createMany([
            ['text' => 'Queues', 'is_correct' => true],
            ['text' => 'Middleware', 'is_correct' => false],
            ['text' => 'Service Providers', 'is_correct' => false],
            ['text' => 'Policies', 'is_correct' => false],
        ]);
    }
}
