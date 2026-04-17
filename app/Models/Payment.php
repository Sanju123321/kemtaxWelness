<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'order_id',
        'amount',
        'status',
        'method',
        'email',
        'contact',
        'purpose',
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
