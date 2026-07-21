<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update cart_items table to point variant_id to variant_sizes table
     * because the cart needs to know the exact color+size combination.
     */
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('variant_id')
                  ->nullable()
                  ->after('product_id')
                  ->constrained('variant_sizes')
                  ->onDelete('cascade');
                  
            $table->unique(
                ['user_id', 'product_id', 'variant_id'],
                'cart_items_user_product_variant_unique'
            );
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreignId('variant_id')
                  ->nullable()
                  ->after('collection_id')
                  ->constrained('variant_sizes')
                  ->onDelete('cascade');
                  
            $table->unique(
                ['user_id', 'product_id', 'collection_id', 'variant_id'],
                'wishlists_user_product_coll_variant_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};
