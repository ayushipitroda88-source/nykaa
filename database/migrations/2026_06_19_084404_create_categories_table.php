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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
             $table->string('name');                        // Category ka naam
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent category ki id (NULL = root)
            $table->integer('position')->default(0);         // Sorting order
            $table->boolean('status')->default(1);            // Active/Inactive

            // Baad mein use honge (Image/Description/Price feature ke liye)
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();

            // Self-referencing relation: parent_id -> categories.id
            $table->foreign('parent_id')
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
        Schema::dropIfExists('categories');
    }
};
