<?php

// Migration 16: 2025_07_15_000016_create_payment_distributions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_enrollment_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('admin_percentage', 5, 2);
            $table->decimal('admin_amount', 10, 2);
            $table->decimal('teacher_percentage', 5, 2);
            $table->decimal('teacher_amount', 10, 2);
            $table->foreignId('admin_wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->foreignId('teacher_wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->timestamp('distributed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_distributions');
    }
};
