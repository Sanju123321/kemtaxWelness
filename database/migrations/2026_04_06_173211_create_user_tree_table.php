<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('user_tree', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');   // new user
        $table->unsignedBigInteger('upline_id'); // parent/upline
        $table->integer('level'); // 1–20

        $table->timestamps();

        // 🔥 Index for performance
        $table->index(['user_id']);
        $table->index(['upline_id']);
        $table->index(['level']);

        // Foreign keys
        $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

        $table->foreign('upline_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tree');
    }
};
