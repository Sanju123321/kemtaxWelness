<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->string('commission_source', 32)->default('referral')->after('type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('pincode');
        });
    }

    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('commission_source');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
};
