<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_bank_details', function (Blueprint $table) {
            if (!$this->columnExists('user_bank_details', 'razorpay_contact_id')) {
                $table->string('razorpay_contact_id')->nullable()->after('upi_id');
            }

            if (!$this->columnExists('user_bank_details', 'razorpay_fund_account_id')) {
                $table->string('razorpay_fund_account_id')->nullable()->after('razorpay_contact_id');
            }
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            if (!$this->columnExists('withdrawal_requests', 'razorpay_contact_id')) {
                $table->string('razorpay_contact_id')->nullable()->after('processed_at');
            }

            if (!$this->columnExists('withdrawal_requests', 'razorpay_fund_account_id')) {
                $table->string('razorpay_fund_account_id')->nullable()->after('razorpay_contact_id');
            }

            if (!$this->columnExists('withdrawal_requests', 'razorpay_payout_id')) {
                $table->string('razorpay_payout_id')->nullable()->after('razorpay_fund_account_id');
            }

            if (!$this->columnExists('withdrawal_requests', 'payout_status')) {
                $table->string('payout_status')->nullable()->after('razorpay_payout_id');
            }

            if (!$this->columnExists('withdrawal_requests', 'payout_reference')) {
                $table->string('payout_reference')->nullable()->after('payout_status');
            }

            if (!$this->columnExists('withdrawal_requests', 'idempotency_key')) {
                $table->string('idempotency_key')->nullable()->after('payout_reference');
            }

            if (!$this->columnExists('withdrawal_requests', 'utr')) {
                $table->string('utr')->nullable()->after('idempotency_key');
            }

            if (!$this->columnExists('withdrawal_requests', 'provider_response')) {
                $table->longText('provider_response')->nullable()->after('utr');
            }
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $columns = array_values(array_filter([
                $this->columnExists('withdrawal_requests', 'razorpay_contact_id') ? 'razorpay_contact_id' : null,
                $this->columnExists('withdrawal_requests', 'razorpay_fund_account_id') ? 'razorpay_fund_account_id' : null,
                $this->columnExists('withdrawal_requests', 'razorpay_payout_id') ? 'razorpay_payout_id' : null,
                $this->columnExists('withdrawal_requests', 'payout_status') ? 'payout_status' : null,
                $this->columnExists('withdrawal_requests', 'payout_reference') ? 'payout_reference' : null,
                $this->columnExists('withdrawal_requests', 'idempotency_key') ? 'idempotency_key' : null,
                $this->columnExists('withdrawal_requests', 'utr') ? 'utr' : null,
                $this->columnExists('withdrawal_requests', 'provider_response') ? 'provider_response' : null,
            ]));

            if ($columns) {
                $table->dropColumn($columns);
            }
        });

        Schema::table('user_bank_details', function (Blueprint $table) {
            $columns = array_values(array_filter([
                $this->columnExists('user_bank_details', 'razorpay_contact_id') ? 'razorpay_contact_id' : null,
                $this->columnExists('user_bank_details', 'razorpay_fund_account_id') ? 'razorpay_fund_account_id' : null,
            ]));

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }

    private function columnExists(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }
};
