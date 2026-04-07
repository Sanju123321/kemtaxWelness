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
    Schema::create('incomes', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');        // who earns
        $table->unsignedBigInteger('from_user_id');   // from whom

        $table->integer('level'); // level 1–20

        $table->double('amount'); // income

        $table->enum('type', ['direct', 'level', 'royalty'])
              ->default('level');

        $table->enum('status', ['pending', 'credited', 'lost'])
              ->default('pending');

        $table->string('remark')->nullable(); // reason (lost etc)

        $table->timestamps();

        // 🔥 Index for speed
        $table->index(['user_id']);
        $table->index(['from_user_id']);
        $table->index(['level']);
        $table->index(['status']);

        // Foreign keys
        $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

        $table->foreign('from_user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
