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
        Schema::create('restaurant_locations', function (Blueprint $table) {
            $table->id();
			$table->string('location_name');
			$table->string('address');
			$table->string('city');
			$table->string('floor_plan')->nullable(); // image
			$table->timestamps();

            // Foreign key
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_locations');
    }
};
