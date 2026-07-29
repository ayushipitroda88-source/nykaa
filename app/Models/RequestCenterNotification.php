<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestCenterNotification extends Model
{
    protected $table = 'request_center_notifications';

    protected $fillable = [
        'seller_id',
        'request_id',
        'title',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(RequestCenterRequest::class, 'request_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}