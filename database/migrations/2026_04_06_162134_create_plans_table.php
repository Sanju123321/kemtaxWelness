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
         Schema::create('plans', function (Blueprint $table) {
        $table->id();

        $table->string('name'); // Starter, Growth...
      

        $table->integer('price'); // 1500
        $table->integer('base_value'); // 1000

        $table->integer('daily_cap'); // 2000
        $table->integer('total_cap'); // 10000
        $table->boolean('is_active')->default(true); // For soft deactivation of plans
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
