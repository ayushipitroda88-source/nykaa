<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'business_name',
        'owner_name',
        'email',
        'phone',
        'password',
        'gst_number',
        'pan_number',
        'business_address',
        'bank_name',
        'bank_account_number',
        'ifsc_code',
        'business_logo',
        'status',
        'rejection_reason',
        'suspension_reason',
        'rejected_at',
        'suspended_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'rejected_at' => 'datetime',
            'suspended_at' => 'datetime',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
