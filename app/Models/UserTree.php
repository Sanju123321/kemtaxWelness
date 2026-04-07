<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTree extends Model
{
    protected $table = 'user_tree';

    protected $fillable = [
        'user_id',
        'upline_id',
        'level'
    ];

    // 🔗 Child user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 Upline user
    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }
}