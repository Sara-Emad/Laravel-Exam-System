<?php

// Migration 13: 2025_07_15_000013_create_student_answers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_choice_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('text_answer')->nullable();
            $table->string('image_answer')->nullable(); // For image uploads
            $table->decimal('awarded_score', 8, 2)->nullable();
            $table->text('teacher_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};