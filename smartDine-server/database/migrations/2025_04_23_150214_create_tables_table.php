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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->json('position');
            $table->bigInteger('number');
            $table->boolean('is_occupied')->default(false);
            $table->smallInteger('floor');
            $table->timestamps();

            // Foreign key
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');

            // Constraints
            $table->unique(['number', 'restaurant_location_id'], 'table_unique_number_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
