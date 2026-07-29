<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'activity',
        'ip_address',
        'details',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    public function getTimeAttribute(): string
    {
        return $this->created_at->format('h:i A');
    }
}