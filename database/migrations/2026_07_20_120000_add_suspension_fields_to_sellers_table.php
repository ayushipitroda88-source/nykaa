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
        Schema::table('sellers', function (Blueprint $table) {
            $table->text('suspension_reason')->nullable()->after('rejection_reason');
            $table->timestamp('rejected_at')->nullable()->after('suspension_reason');
            $table->timestamp('suspended_at')->nullable()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['suspension_reason', 'rejected_at', 'suspended_at']);
        });
    }
};