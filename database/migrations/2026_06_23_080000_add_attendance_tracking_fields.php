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
        Schema::table('attendances', function (Blueprint $table) {
            if (! Schema::hasColumn('attendances', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }

            if (! Schema::hasColumn('attendances', 'attendance_date')) {
                $table->date('attendance_date')->nullable();
            }

            if (! Schema::hasColumn('attendances', 'status')) {
                $table->string('status', 20)->default('Working');
                $table->index('status');
            }

            $table->unique(['user_id', 'attendance_date'], 'attendances_user_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('attendances_user_date_unique');

            if (Schema::hasColumn('attendances', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('attendances', 'attendance_date')) {
                $table->dropColumn('attendance_date');
            }

            if (Schema::hasColumn('attendances', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
