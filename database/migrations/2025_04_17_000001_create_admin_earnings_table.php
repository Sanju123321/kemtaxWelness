<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_earnings', function (Blueprint $table) {
            $table->id();
            // The user whose plan purchase triggered the commission chain
            $table->unsignedBigInteger('from_user_id')->nullable()->index();
            // The upline user who earned/lost the original commission
            $table->unsignedBigInteger('beneficiary_user_id')->nullable()->index();
            // maintenance_fee = 10% of credited commission | lost_capture = full lost amount
            $table->enum('type', ['maintenance_fee', 'lost_capture']);
            $table->decimal('amount', 12, 2);
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('beneficiary_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_earnings');
    }
};
