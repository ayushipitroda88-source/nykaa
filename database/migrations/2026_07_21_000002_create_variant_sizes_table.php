<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create variant_sizes table.
     * This table stores the nested sizes, prices, and quantities for a color variant.
     */
    public function up(): void
    {
        Schema::create('variant_sizes', function (Blueprint $table) {
            $table->id();
            
            // FK to product_variants (which represents the color)
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade');
            
            // FK to sizes
            $table->foreignId('size_id')->constrained('sizes')->onDelete('cascade');
            
            // Price and stock for this specific color + size combination
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            
            $table->timestamps();
            
            // A variant (color) can only have one row per specific size
            $table->unique(['variant_id', 'size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_sizes');
    }
};
