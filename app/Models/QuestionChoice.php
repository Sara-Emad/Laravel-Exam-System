<?php

// Model 12: QuestionChoice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'title',
        'description',
        'image',
        'degree',
        'is_correct',
        'order',
    ];

    protected $casts = [
        'degree' => 'decimal:2',
        'is_correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
