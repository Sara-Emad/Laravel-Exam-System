<?php
// Model 14: ExamAttempt.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_enrollment_id',
        'student_id',
        'exam_id',
        'attempt_number',
        'started_at',
        'submitted_at',
        'score',
        'percentage',
        'is_passed',
        'status',
        'teacher_feedback',
        'graded_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'is_passed' => 'boolean',
    ];

    public function examEnrollment(): BelongsTo
    {
        return $this->belongsTo(ExamEnrollment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function calculateScore(): float
    {
        return $this->studentAnswers()->sum('awarded_score') ?? 0;
    }
}

