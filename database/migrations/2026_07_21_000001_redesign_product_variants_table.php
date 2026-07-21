<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Redesign product_variants table:
     * - Remove size_id, price, quantity (moved to variant_sizes table)
     * - Add priority (unique per product for display ordering)
     * - image stays here (color-level, one image per color variant)
     *
     * Architecture: One Variant = One Color + One Image + Priority
     * Sizes/prices/quantities live in variant_sizes table.
     */
    public function up(): void
    {
        // Drop all existing variant data (breaking schema change)
        \Illuminate\Support\Facades\DB::table('product_variants')->truncate();
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE cart_items DROP FOREIGN KEY cart_items_user_id_foreign"); } catch (\Exception $e) {}
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE cart_items DROP FOREIGN KEY cart_items_variant_id_foreign"); } catch (\Exception $e) {}
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE cart_items DROP INDEX cart_items_user_product_variant_unique"); } catch (\Exception $e) {}

        // Safe drop constraints for wishlists (executed immediately)
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE wishlists DROP FOREIGN KEY wishlists_user_id_foreign"); } catch (\Exception $e) {}
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE wishlists DROP FOREIGN KEY wishlists_variant_id_foreign"); } catch (\Exception $e) {}
        try { \Illuminate\Support\Facades\DB::statement("ALTER TABLE wishlists DROP INDEX wishlists_user_product_coll_variant_unique"); } catch (\Exception $e) {}

        Schema::table('cart_items', function (Blueprint $table) {
            if (Schema::hasColumn('cart_items', 'variant_id')) {
                $table->dropColumn('variant_id');
            }
            
            // Re-add the user_id foreign key that was dropped
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('wishlists', function (Blueprint $table) {
            if (Schema::hasColumn('wishlists', 'variant_id')) {
                $table->dropColumn('variant_id');
            }

            // Re-add the user_id foreign key that was dropped
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Rebuild product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            // Drop old columns that no longer belong at color level
            if (Schema::hasColumn('product_variants', 'size_id')) {
                $table->dropForeign(['size_id']);
                $table->dropColumn('size_id');
            }
            if (Schema::hasColumn('product_variants', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('product_variants', 'quantity')) {
                $table->dropColumn('quantity');
            }

            // Make image nullable (we upload on variant create)
            $table->string('image')->nullable()->change();

            // Add priority column: controls display order on product page
            if (!Schema::hasColumn('product_variants', 'priority')) {
                $table->unsignedInteger('priority')->default(1)->after('color_id');
            }
        });

        // Add unique constraint: one priority per product
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unique(['product_id', 'priority'], 'product_variants_product_priority_unique');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique('product_variants_product_priority_unique');
            $table->dropColumn('priority');
            $table->foreignId('size_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
        });

        // Restore cart_items variant_id (pointing back to product_variants)
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('variant_id')
                  ->nullable()
                  ->after('product_id')
                  ->constrained('product_variants')
                  ->onDelete('cascade');
        });
    }
};
