<?php

// Model 16: Certificate.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'student_id',
        'exam_id',
        'certificate_number',
        'pdf_path',
        'issued_at',
        'email_sent',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function generateCertificateNumber(): string
    {
        return 'CERT-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
