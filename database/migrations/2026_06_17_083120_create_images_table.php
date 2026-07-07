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
        if (Schema::hasTable('products')) {
        return;
    }
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
        $table->string('image');
        $table->text('description');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();
            
            // Foreign key relationship
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
