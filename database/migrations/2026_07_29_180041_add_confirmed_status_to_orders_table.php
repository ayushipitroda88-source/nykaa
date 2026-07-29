<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Change orders status column to string so we can accept any value
        //    (MySQL enum changes are tricky; using string is more flexible)
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
            $table->timestamp('confirmed_at')->nullable()->after('status');
        });

        // 2. Change reviews status to auto-approve (no moderation delay for customers)
        // We make it so reviews default to 'approved' for immediate visibility
        Schema::table('reviews', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('confirmed_at');
            $table->string('status')->default('pending')->change();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
};
