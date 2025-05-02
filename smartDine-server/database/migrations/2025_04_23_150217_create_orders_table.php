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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('waiter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
