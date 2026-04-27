<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'from_user_id',
        'level',
        'amount',
        'type',
        'commission_source',
        'status',
        'remark'
    ];

    // 🔗 Who earns
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 From whom
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}