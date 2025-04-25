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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('google_id')->nullable();
			$table->string('provider')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('password')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->rememberToken();
			$table->timestamps();

			// Foreign keys
			$table->foreignId('user_type_id')->constrained('user_types')->onDelete('cascade');
			$table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('set null');
			$table->foreignId('restaurant_location_id')->nullable()->constrained('restaurant_locations')->onDelete('set null');
            
            $table->index('restaurant_location_id');
		});

		Schema::create('password_reset_tokens', function (Blueprint $table) {
			$table->string('email')->primary();
			$table->string('token');
			$table->timestamp('created_at')->nullable();
		});

		Schema::create('sessions', function (Blueprint $table) {
			$table->string('id')->primary();
			$table->foreignId('user_id')->nullable()->index();
			$table->string('ip_address', 45)->nullable();
			$table->text('user_agent')->nullable();
			$table->longText('payload');
			$table->integer('last_activity')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
		Schema::dropIfExists('password_reset_tokens');
		Schema::dropIfExists('sessions');
	}
};