<?php

// Model 7: Wallet.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'owner_type',
        'owner_id',
        'balance',
        'pending_balance',
        'is_active',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function addBalance(float $amount, string $description, string $referenceType = null, int $referenceId = null): void
    {
        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'description' => $description,
        ]);
    }

    public function subtractBalance(float $amount, string $description, string $referenceType = null, int $referenceId = null): void
    {
        $this->balance -= $amount;
        $this->save();

        $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'description' => $description,
        ]);
    }
}

