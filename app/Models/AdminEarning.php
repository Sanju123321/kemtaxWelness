<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEarning extends Model
{
    protected $fillable = [
        'from_user_id',
        'beneficiary_user_id',
        'type',
        'amount',
        'remark',
    ];

    /** The user whose payment triggered the commission */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /** The upline user who had the original commission entry */
    public function beneficiaryUser()
    {
        return $this->belongsTo(User::class, 'beneficiary_user_id');
    }
}
