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
        // 1. Add average_rating & total_reviews to products table
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'average_rating')) {
                $table->decimal('average_rating', 3, 2)->default(0.00)->after('status');
            }
            if (!Schema::hasColumn('products', 'total_reviews')) {
                $table->unsignedInteger('total_reviews')->default(0)->after('average_rating');
            }
        });

        // 2. Ensure orders status can accommodate 'delivered'
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // 3. Create reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->nullOnDelete();
            $table->unsignedTinyInteger('rating'); // 1 to 5
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_verified_purchase')->default(true);
            $table->unsignedInteger('helpful_count')->default(0);
            $table->timestamps();

            // A customer can submit ONLY ONE review per product
            $table->unique(['user_id', 'product_id']);
        });

        // 4. Create review_images table
        Schema::create('review_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });

        // 5. Create review_replies table (Seller responses)
        Schema::create('review_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained()->cascadeOnDelete();
            $table->text('reply');
            $table->timestamps();
        });

        // 6. Create review_helpful table (Prevent duplicate votes)
        Schema::create('review_helpful', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['review_id', 'user_id']);
        });

        // 7. Create review_reports table
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('reason', ['spam', 'fake_review', 'abusive_language', 'misleading_information', 'other']);
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reports');
        Schema::dropIfExists('review_helpful');
        Schema::dropIfExists('review_replies');
        Schema::dropIfExists('review_images');
        Schema::dropIfExists('reviews');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'total_reviews']);
        });
    }
};
