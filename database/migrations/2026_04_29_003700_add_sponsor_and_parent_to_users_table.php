<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'sponsor_id')) {
                $table->unsignedBigInteger('sponsor_id')->nullable()->after('referred_by');
                $table->index('sponsor_id');
            }

            if (!Schema::hasColumn('users', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('sponsor_id');
                $table->index('parent_id');
            }
        });

        // Keep existing production records compatible with new fields.
        DB::table('users')
            ->whereNull('sponsor_id')
            ->whereNotNull('referred_by')
            ->update(['sponsor_id' => DB::raw('referred_by')]);

        DB::table('users')
            ->whereNull('parent_id')
            ->whereNotNull('sponsor_id')
            ->update(['parent_id' => DB::raw('sponsor_id')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'parent_id')) {
                $table->dropIndex(['parent_id']);
                $table->dropColumn('parent_id');
            }

            if (Schema::hasColumn('users', 'sponsor_id')) {
                $table->dropIndex(['sponsor_id']);
                $table->dropColumn('sponsor_id');
            }
        });
    }
};
