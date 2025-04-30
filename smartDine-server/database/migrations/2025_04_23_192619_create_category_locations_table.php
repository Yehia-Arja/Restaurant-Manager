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
        Schema::create('category_locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Foreign keys
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');

            $table->unique(['category_id', 'restaurant_location_id']);
            $table->index('restaurant_location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_locations');
    }
};
