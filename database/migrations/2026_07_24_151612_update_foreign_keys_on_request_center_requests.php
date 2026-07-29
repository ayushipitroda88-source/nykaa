<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change product_id and variant_id foreign keys from ON DELETE CASCADE to ON DELETE SET NULL
     * so that deleting a product or variant doesn't cascade-delete the request record.
     */
    public function up(): void
    {
        Schema::table('request_center_requests', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['product_id']);
            $table->dropForeign(['variant_id']);

            // Re-add with ON DELETE SET NULL
            $table->foreignId('product_id')->nullable()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            $table->foreignId('variant_id')->nullable()->change();
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_center_requests', function (Blueprint $table) {
            // Drop the SET NULL foreign keys
            $table->dropForeign(['product_id']);
            $table->dropForeign(['variant_id']);

            // Restore original CASCADE foreign keys
            $table->foreignId('product_id')->nullable()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->foreignId('variant_id')->nullable()->change();
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }
};