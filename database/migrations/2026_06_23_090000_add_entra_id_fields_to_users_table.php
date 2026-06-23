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
        Schema::table('users', function (Blueprint $table) {
            $table->string('entra_id')->nullable()->unique()->comment('Microsoft Entra ID object ID');
            $table->string('azure_tenant_id')->nullable()->comment('Azure tenant ID');
            $table->string('entra_email')->nullable()->comment('Email from Entra ID');
            $table->json('entra_profile')->nullable()->comment('Full Entra ID profile data');
            $table->timestamp('entra_synced_at')->nullable()->comment('Last sync timestamp from Entra ID');
            $table->string('auth_provider')->default('local')->comment('Authentication provider (local, entra)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['entra_id']);
            $table->dropColumn([
                'entra_id',
                'azure_tenant_id',
                'entra_email',
                'entra_profile',
                'entra_synced_at',
                'auth_provider',
            ]);
        });
    }
};
