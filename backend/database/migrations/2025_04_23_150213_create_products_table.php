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
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('file_name');
			$table->text('description');
			$table->decimal('price', 8, 2);
			$table->string('time_to_deliver');
			$table->text('ingredients');
			$table->timestamps();

			// Foreign keys
			$table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
			$table->foreignId('restaurant_location_id')->constrained('restaurant_locations')->onDelete('cascade');
            
            $table->index('restaurant_location_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('products');
	}
};