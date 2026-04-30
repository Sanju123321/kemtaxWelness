<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'reference_code',
        'referred_by',
        'sponsor_id',
        'parent_id',
        'email_verified_at',
        'password',
        'remember_token',
        'status',
        'has_plan',
        'current_plan_id',
        'wallet_balance',
        'total_earned',
        'profile_photo',
        'city',
        'state',
        'pincode',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function recentlyViewed(): HasMany
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function directs(): HasMany
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function currentPlan()
    {
        return $this->belongsTo(Plan::class, 'current_plan_id');
    }

    public function plans()
    {
        return $this->hasMany(UserPlan::class);
    }

    public function bankDetail()
    {
        return $this->hasOne(UserBankDetail::class);
    }

    public function getDirectReferralCount(): int
    {
        return static::query()
            ->where(function ($query) {
                $query->where('sponsor_id', $this->id)
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('sponsor_id')
                            ->where('referred_by', $this->id);
                    });
            })
            ->count();
    }

    public function getRoyaltyLevel(): int
    {
        $directs = $this->getDirectReferralCount();

        if ($directs >= 50) {
            return 4;
        }

        if ($directs >= 30) {
            return 3;
        }

        if ($directs >= 20) {
            return 2;
        }

        if ($directs >= 15) {
            return 1;
        }

        return 0;
    }

    public function getRoyaltyPercentage(): float
    {
        return match ($this->getRoyaltyLevel()) {
            4 => 20.0, // 10 + 5 + 3 + 2
            3 => 18.0, // 10 + 5 + 3
            2 => 15.0, // 10 + 5
            1 => 10.0, // 10
            default => 0.0,
        };
    }
}
