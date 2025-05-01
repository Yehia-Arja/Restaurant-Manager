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
        Schema::create('product_insights', function (Blueprint $table) {
            $table->id();
            $table->integer('order_count')->default(0); // Total orders for this product at this branch
            $table->decimal('avg_rating', 3, 2)->default(0); // Average rating
            $table->integer('rating_count')->default(0);    // Total reviews
            $table->json('latest_comments')->nullable();    // Last 5 review comments

            $table->timestamps();

            $table->unique(['product_id', 'restaurant_location_id']);

            // Foreign keys
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_insights');
    }
};
