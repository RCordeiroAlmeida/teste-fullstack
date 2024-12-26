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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->string('location_name');
            $table->string('region');
            $table->string('country');
            $table->decimal('temperature', 5, 2);
            $table->string('description');
            $table->decimal('wind_speed', 5, 2);
            $table->integer('pressure');
            $table->integer('humidity');
            $table->decimal('visibility', 5, 2);
            $table->integer('uv_index');
            $table->decimal('feelslike', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
