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
        Schema::create('staff_locations', function (Blueprint $table) {
            // Composite primary key
            $table->primary(['user_id', 'restaurant_location_id']);
            $table->string('role')->default('staff'); // You can change this to nullable() if role is optional
            $table->timestamps();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_locations');
    }
};
