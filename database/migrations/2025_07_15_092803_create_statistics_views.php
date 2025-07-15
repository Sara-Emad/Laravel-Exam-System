<?php

// Migration 17: 2025_07_15_000017_create_statistics_views.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Admin Statistics View
        DB::statement('
            CREATE VIEW admin_statistics_view AS
            SELECT 
                (SELECT COUNT(*) FROM teachers WHERE status = "approved") as registered_teachers,
                (SELECT COUNT(*) FROM teachers WHERE status = "pending") as pending_teacher_requests,
                (SELECT COUNT(*) FROM students) as registered_students,
                (SELECT COUNT(*) FROM exams WHERE is_active = 1) as created_exams,
                (SELECT COUNT(*) FROM exam_attempts) as exam_attempts,
                (SELECT COUNT(*) FROM certificates) as certificates_issued,
                (SELECT COUNT(*) FROM exam_attempts WHERE is_passed = 1) as passed_students,
                (SELECT COUNT(*) FROM exam_attempts WHERE is_passed = 0) as failed_students,
                (SELECT COALESCE(SUM(balance), 0) FROM wallets WHERE type = "system") as system_wallet_balance,
                (SELECT COALESCE(SUM(paid_amount), 0) FROM exam_enrollments WHERE payment_status = "completed") as total_revenue,
                (SELECT COALESCE(SUM(teacher_amount), 0) FROM payment_distributions) as total_distributed_to_teachers
        ');

        // Teacher Statistics View
        DB::statement('
            CREATE VIEW teacher_statistics_view AS
            SELECT 
                t.id as teacher_id,
                t.name as teacher_name,
                COUNT(DISTINCT e.id) as exams_created,
                COUNT(DISTINCT ee.student_id) as students_enrolled,
                COUNT(DISTINCT ea.id) as exam_attempts_submitted,
                COUNT(CASE WHEN ea.status = "graded" THEN 1 END) as graded_submissions,
                COUNT(CASE WHEN ea.status IN ("submitted", "in_progress") THEN 1 END) as ungraded_submissions,
                COUNT(DISTINCT c.id) as certificates_issued,
                COALESCE(SUM(pd.teacher_amount), 0) as total_revenue_earned,
                COALESCE(w.balance, 0) as current_wallet_balance
            FROM teachers t
            LEFT JOIN exams e ON t.id = e.teacher_id
            LEFT JOIN exam_enrollments ee ON e.id = ee.exam_id
            LEFT JOIN exam_attempts ea ON ee.id = ea.exam_enrollment_id
            LEFT JOIN certificates c ON ea.id = c.exam_attempt_id
            LEFT JOIN payment_distributions pd ON ee.id = pd.exam_enrollment_id
            LEFT JOIN wallets w ON t.id = w.owner_id AND w.owner_type = "App\\\\Models\\\\Teacher"
            WHERE t.status = "approved"
            GROUP BY t.id, t.name, w.balance
        ');

        // Student Statistics View
        DB::statement('
            CREATE VIEW student_statistics_view AS
            SELECT 
                s.id as student_id,
                s.name as student_name,
                COUNT(DISTINCT ee.exam_id) as enrolled_exams,
                COUNT(CASE WHEN ea.is_passed = 1 THEN 1 END) as passed_count,
                COUNT(CASE WHEN ea.is_passed = 0 THEN 1 END) as failed_count,
                COALESCE(SUM(ee.paid_amount), 0) as total_spent_amount,
                COALESCE(w.balance, 0) as current_wallet_balance
            FROM students s
            LEFT JOIN exam_enrollments ee ON s.id = ee.student_id
            LEFT JOIN exam_attempts ea ON ee.id = ea.exam_enrollment_id
            LEFT JOIN wallets w ON s.id = w.owner_id AND w.owner_type = "App\\\\Models\\\\Student"
            GROUP BY s.id, s.name, w.balance
        ');
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS admin_statistics_view');
        DB::statement('DROP VIEW IF EXISTS teacher_statistics_view');
        DB::statement('DROP VIEW IF EXISTS student_statistics_view');
    }
};
