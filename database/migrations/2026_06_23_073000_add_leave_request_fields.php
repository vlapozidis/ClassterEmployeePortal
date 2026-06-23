<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('leave_requests', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }

            if (! Schema::hasColumn('leave_requests', 'department_id')) {
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('leave_requests', 'start_date')) {
                $table->date('start_date')->nullable();
            }

            if (! Schema::hasColumn('leave_requests', 'end_date')) {
                $table->date('end_date')->nullable();
            }

            if (! Schema::hasColumn('leave_requests', 'reason')) {
                $table->text('reason')->nullable();
            }

            if (! Schema::hasColumn('leave_requests', 'status')) {
                $table->string('status', 20)->default('Pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            if (Schema::hasColumn('leave_requests', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('leave_requests', 'reason')) {
                $table->dropColumn('reason');
            }

            if (Schema::hasColumn('leave_requests', 'end_date')) {
                $table->dropColumn('end_date');
            }

            if (Schema::hasColumn('leave_requests', 'start_date')) {
                $table->dropColumn('start_date');
            }

            if (Schema::hasColumn('leave_requests', 'department_id')) {
                $table->dropConstrainedForeignId('department_id');
            }

            if (Schema::hasColumn('leave_requests', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
