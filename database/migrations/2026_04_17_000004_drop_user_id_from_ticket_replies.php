<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the orphaned user_id column from ticket_replies.
        // Admin replies now use admin_id (added in 2026_04_17_000003).
        // Member replies don't exist yet (members open tickets, admin replies).
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('ticket_id');
        });
    }
};
