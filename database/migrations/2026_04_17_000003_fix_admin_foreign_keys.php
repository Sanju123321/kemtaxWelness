<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix withdrawal_requests.processed_by FK: users → admins
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->foreign('processed_by')->references('id')->on('admins')->onDelete('set null');
        });

        // Fix kyc_documents.verified_by FK: users → admins
        Schema::table('kyc_documents', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });

        // Fix ticket_replies: drop user_id FK (it stored admin IDs), add admin_id column
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('admin_id')->nullable()->after('user_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('kyc_documents', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
