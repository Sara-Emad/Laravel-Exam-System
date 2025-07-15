<?php

// Model 11: Question.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'title',
        'description',
        'image',
        'type',
        'degree',
        'order',
    ];

    protected $casts = [
        'degree' => 'decimal:2',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(QuestionChoice::class);
    }

    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function isCheckboxType(): bool
    {
        return $this->type === 'checkbox';
    }

    public function isTextType(): bool
    {
        return $this->type === 'text';
    }

    public function getCorrectChoices(): HasMany
    {
        return $this->choices()->where('is_correct', true);
    }
}


