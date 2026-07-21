<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add SKU and Status to product_variants.
     * Add original_price to variant_sizes.
     */
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('priority');
            $table->boolean('status')->default(1)->after('image')->comment('1=Active, 0=Inactive');
        });

        Schema::table('variant_sizes', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['sku', 'status']);
        });

        Schema::table('variant_sizes', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });
    }
};
