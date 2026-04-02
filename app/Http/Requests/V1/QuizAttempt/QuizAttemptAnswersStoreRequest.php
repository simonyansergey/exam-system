<?php

namespace App\Http\Requests\V1\QuizAttempt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizAttemptAnswersStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question_id' => ['required', 'integer', Rule::exists('questions', 'id')],
            'option_id' => ['required', 'integer', Rule::exists('question_options', 'id')]
        ];
    }
}
