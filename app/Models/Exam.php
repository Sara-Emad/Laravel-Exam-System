<?php

// Model 10: Exam.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'total_degree',
        'price',
        'passing_score',
        'teacher_id',
        'is_active',
    ];

    protected $casts = [
        'total_degree' => 'decimal:2',
        'price' => 'decimal:2',
        'passing_score' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(ExamEnrollment::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function getQuestionsCount(): int
    {
        return $this->questions()->count();
    }

    public function getEnrolledStudentsCount(): int
    {
        return $this->enrollments()->count();
    }
}

