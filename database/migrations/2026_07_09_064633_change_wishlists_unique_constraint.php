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
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique('wishlists_user_id_product_id_collection_id_unique');
            
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            
            $table->unique(
                ['user_id', 'product_id', 'collection_id', 'variant_id'],
                'wishlists_user_product_coll_variant_unique'
            );
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique('wishlists_user_product_coll_variant_unique');
            
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
            
            $table->unique(
                ['user_id', 'product_id', 'collection_id'],
                'wishlists_user_id_product_id_collection_id_unique'
            );
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
