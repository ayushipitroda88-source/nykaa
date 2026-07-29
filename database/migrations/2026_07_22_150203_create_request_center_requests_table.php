<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_center_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->string('request_type'); // product_edit, product_delete, variant_edit, variant_delete
            $table->string('status')->default('pending'); // pending, approved, rejected, need_more_info
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable();
            
            // Store requested changes as JSON (what the seller wants to change)
            $table->json('requested_data')->nullable();
            
            // Store current live data as JSON (snapshot at time of request)
            $table->json('current_data')->nullable();
            
            // Admin review fields
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('request_center_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('request_center_requests')->onDelete('cascade');
            $table->foreignId('seller_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('request_center_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->foreignId('request_id')->constrained('request_center_requests')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_center_notifications');
        Schema::dropIfExists('request_center_conversations');
        Schema::dropIfExists('request_center_requests');
    }
};