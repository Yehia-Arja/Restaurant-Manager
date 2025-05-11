<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('favoritable_id');
            $table->string('favoritable_type');
            $table->timestamps();

            // Unique constraint
            $table->unique(['user_id', 'favoritable_id', 'favoritable_type'], 'user_fav_unique');

            // Foreign key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
