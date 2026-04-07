<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'amount_paid',
        'status',
        'activated_at'
    ];

    // 🔗 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}