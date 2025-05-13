<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
return new class extends Migration
{
    /**
     * Run the migrations.
     */
=======
return new class extends Migration {
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->timestamps();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('cascade');

            // Uniqueness for product and restaurant favorites
            $table->unique(['user_id', 'product_id']);
            $table->unique(['user_id', 'restaurant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
=======
            $table->unsignedBigInteger('favoritable_id');
            $table->string('favoritable_type');
            $table->timestamps();

            // Unique constraint
            $table->unique(['user_id', 'favoritable_id', 'favoritable_type'], 'user_fav_unique');

            // Foreign key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
