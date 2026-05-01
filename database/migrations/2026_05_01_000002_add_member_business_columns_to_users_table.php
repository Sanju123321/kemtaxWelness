<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'user_id')) {
                $table->string('user_id')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'reference_code')) {
                $table->string('reference_code')->nullable()->unique()->after('phone');
            }
            if (!Schema::hasColumn('users', 'referred_by')) {
                $table->unsignedBigInteger('referred_by')->nullable()->after('reference_code');
            }
            if (!Schema::hasColumn('users', 'sponsor_id')) {
                $table->unsignedBigInteger('sponsor_id')->nullable()->after('referred_by');
            }
            if (!Schema::hasColumn('users', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('sponsor_id');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('inactive')->after('password');
            }
            if (!Schema::hasColumn('users', 'has_plan')) {
                $table->boolean('has_plan')->default(false)->after('status');
            }
            if (!Schema::hasColumn('users', 'current_plan_id')) {
                $table->unsignedBigInteger('current_plan_id')->nullable()->after('has_plan');
            }
            if (!Schema::hasColumn('users', 'wallet_balance')) {
                $table->decimal('wallet_balance', 12, 2)->default(0)->after('current_plan_id');
            }
            if (!Schema::hasColumn('users', 'total_earned')) {
                $table->decimal('total_earned', 12, 2)->default(0)->after('wallet_balance');
            }
            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('profile_photo');
            }
            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'pincode')) {
                $table->string('pincode')->nullable()->after('state');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('pincode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'user_id',
                'reference_code',
                'referred_by',
                'sponsor_id',
                'parent_id',
                'status',
                'has_plan',
                'current_plan_id',
                'wallet_balance',
                'total_earned',
                'profile_photo',
                'city',
                'state',
                'pincode',
                'address',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
