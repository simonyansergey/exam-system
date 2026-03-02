<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'text',
        'type'
    ];

    protected function casts(): array
    {
        return [
            'type' => QuestionTypeEnum::class
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
