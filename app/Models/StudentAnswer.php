<?php

// Model 15: StudentAnswer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'question_choice_id',
        'text_answer',
        'image_answer',
        'awarded_score',
        'teacher_comment',
    ];

    protected $casts = [
        'awarded_score' => 'decimal:2',
    ];

    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function questionChoice(): BelongsTo
    {
        return $this->belongsTo(QuestionChoice::class);
    }

    public function isTextAnswer(): bool
    {
        return !empty($this->text_answer);
    }

    public function isChoiceAnswer(): bool
    {
        return !empty($this->question_choice_id);
    }

    public function hasImageAnswer(): bool
    {
        return !empty($this->image_answer);
    }
}