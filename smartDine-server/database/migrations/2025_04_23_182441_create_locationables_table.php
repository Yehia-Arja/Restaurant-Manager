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
        Schema::create('locationables', function (Blueprint $table) {
            $table->unsignedBigInteger('locationable_id');
            $table->string('locationable_type'); // 'Product' or 'Category'

            $table->decimal('override_price', 8, 2)->nullable(); // For products only
            $table->string('override_description')->nullable();  // For products only

            $table->timestamps();

            $table->primary(['locationable_id', 'locationable_type', 'restaurant_location_id'], 'locationables_composite');

            // Foreign key
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locationables');
    }
};
