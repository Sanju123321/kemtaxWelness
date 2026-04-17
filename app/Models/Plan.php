<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'code',
        'price',
        'base_value',
        'daily_cap',
        'total_cap',
        'is_active',
    ];

    // 🔗 Users having this as current plan
    public function users()
    {
        return $this->hasMany(User::class, 'current_plan_id');
    }

    // 🔗 Plan history
    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }
}