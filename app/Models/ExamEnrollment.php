<?php

// Model 13: ExamEnrollment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExamEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'paid_amount',
        'payment_status',
        'enrolled_at',
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'enrolled_at' => 'datetime',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function paymentDistribution(): HasOne
    {
        return $this->hasOne(PaymentDistribution::class);
    }

    public function isPaymentCompleted(): bool
    {
        return $this->payment_status === 'completed';
    }

    public function isPaymentPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function getAttemptsCount(): int
    {
        return $this->attempts()->count();
    }
}

