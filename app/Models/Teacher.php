<?php

// Model 5: Teacher.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'specializations',
        'biography',
        'phone',
        'profile_image',
        'cv_file',
        'status',
        'revenue_percentage',
        'role_id',
        'is_active',
        'approved_at',
        'approved_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'is_active' => 'boolean',
        'revenue_percentage' => 'decimal:2',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    public function paymentDistributions(): HasMany
    {
        return $this->hasMany(PaymentDistribution::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}

