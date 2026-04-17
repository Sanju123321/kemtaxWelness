<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'status', 'payment_method',
        'account_holder', 'account_number', 'ifsc', 'bank_name',
        'upi_id', 'admin_remark', 'processed_by', 'processed_at',
        'razorpay_contact_id', 'razorpay_fund_account_id', 'razorpay_payout_id',
        'payout_status', 'payout_reference', 'idempotency_key', 'utr',
        'provider_response',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount'       => 'decimal:2',
        'provider_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }
}
