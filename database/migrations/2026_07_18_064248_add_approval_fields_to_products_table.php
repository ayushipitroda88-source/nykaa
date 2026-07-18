<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds comprehensive approval workflow fields to the products table.
     * - rejection_reason: stores admin's rejection reason
     * - approved_by: references the admin who approved the product
     * - approved_at: timestamp when product was approved
     * - status: updated enum to include 'resubmitted'
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Change status enum to include 'resubmitted'
            $table->string('status')->default('pending')->change();
            
            // Add new approval workflow columns
            $table->text('rejection_reason')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->after('rejection_reason')
                  ->constrained('admins')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });

        // Update existing records: convert old enum values to string
        DB::table('products')->where('status', 'pending')->update(['status' => 'pending']);
        DB::table('products')->where('status', 'approved')->update(['status' => 'approved']);
        DB::table('products')->where('status', 'rejected')->update(['status' => 'rejected']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['rejection_reason', 'approved_by', 'approved_at']);
            
            // Revert status back to enum
            DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
        });
    }
};