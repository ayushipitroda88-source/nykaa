<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('wishlists', function (Blueprint $table) {
            // Drop old unique constraint
            $table->dropUnique(['user_id', 'product_id']);
            
            // Add collection_id
            $table->foreignId('collection_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
                
            // Add new unique constraint
            $table->unique(['user_id', 'product_id', 'collection_id']);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id', 'collection_id']);
            $table->dropColumn('collection_id');
            $table->unique(['user_id', 'product_id']);
        });
        Schema::enableForeignKeyConstraints();
    }
};
