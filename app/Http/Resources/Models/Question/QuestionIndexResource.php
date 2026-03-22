<?php

namespace App\Http\Resources\Models\Question;

use App\Http\Resources\Models\QuestionOption\QuestionOptionIndexResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_text' => $this->text,
            'question_options' => QuestionOptionIndexResource::collection($this->questionOptions)
        ];
    }
}
