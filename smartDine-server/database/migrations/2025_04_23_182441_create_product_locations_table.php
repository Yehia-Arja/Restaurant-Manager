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
        Schema::create('product_locations', function (Blueprint $table) {
            $table->id();
            $table->decimal('override_price')->nullable();
            $table->string('override_description')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
            
            $table->unique(['product_id', 'restaurant_location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_locations');
    }
};
