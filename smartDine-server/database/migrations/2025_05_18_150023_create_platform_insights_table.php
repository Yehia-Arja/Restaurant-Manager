<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformInsightsTable extends Migration
{
    public function up()
    {
        Schema::create('platform_insights', function (Blueprint $table) {
            $table->string('month')->primary();

            $table->unsignedInteger('owners_count')->default(0);
            $table->unsignedInteger('clients_count')->default(0);
            $table->unsignedInteger('new_clients_count')->default(0);
            $table->decimal('clients_growth_pct', 5, 2)->nullable();

            $table->unsignedInteger('restaurants_count')->default(0);
            $table->unsignedInteger('new_restaurants_count')->default(0);
            $table->decimal('restaurants_growth_pct', 5, 2)->nullable();

            $table->unsignedInteger('products_count')->default(0);
            $table->unsignedInteger('occupied_tables_count')->default(0);

            $table->unsignedInteger('total_orders_count')->default(0);
            $table->unsignedInteger('completed_orders_count')->default(0);
            $table->decimal('orders_completion_pct', 5, 2)->nullable();

            $table->decimal('total_revenue', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('platform_insights');
    }
}
