<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepurchaseWalletTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'bank_reference',
        'proof',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
