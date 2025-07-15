<?php

// Model 9: PaymentDistribution.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_enrollment_id',
        'total_amount',
        'admin_percentage',
        'admin_amount',
        'teacher_percentage',
        'teacher_amount',
        'admin_wallet_id',
        'teacher_wallet_id',
        'distributed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'admin_percentage' => 'decimal:2',
        'admin_amount' => 'decimal:2',
        'teacher_percentage' => 'decimal:2',
        'teacher_amount' => 'decimal:2',
        'distributed_at' => 'datetime',
    ];

    public function examEnrollment(): BelongsTo
    {
        return $this->belongsTo(ExamEnrollment::class);
    }

    public function adminWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'admin_wallet_id');
    }

    public function teacherWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'teacher_wallet_id');
    }
}

