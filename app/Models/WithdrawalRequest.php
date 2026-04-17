<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'status', 'payment_method',
        'account_holder', 'account_number', 'ifsc', 'bank_name',
        'upi_id', 'admin_remark', 'processed_by', 'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount'       => 'decimal:2',
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
