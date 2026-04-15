<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetail extends Model
{
    protected $table = 'user_bank_details';
    protected $fillable = [
        'user_id',
        'account_holder',
        'account_number',
        'ifsc',
        'bank_name',
        'upi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
