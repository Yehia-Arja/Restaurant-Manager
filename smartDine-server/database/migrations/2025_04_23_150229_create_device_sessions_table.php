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
        Schema::create('device_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('device_name'); // e.g., "iPhone 12", "Samsung Galaxy S21"           
            $table->string('ip_address', 45)->nullable(); // IPv4 or IPv6
            $table->text('user_agent')->nullable(); // Browser and OS information
            $table->timestamp('last_used_at')->nullable();
            $table->boolean('is_active')->default(true);  
            $table->timestamps();  
            
            // Foreign key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_sessions');
    }
};
