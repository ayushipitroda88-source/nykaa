<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestCenterRequest extends Model
{
    use SoftDeletes;

    protected $table = 'request_center_requests';

    protected $fillable = [
        'request_number',
        'seller_id',
        'request_type',
        'status',
        'product_id',
        'variant_id',
        'reason',
        'notes',
        'attachment',
        'requested_data',
        'current_data',
        'reviewed_by',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'requested_data' => 'array',
        'current_data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    const REQUEST_TYPES = [
        'product_edit',
        'product_delete',
        'variant_edit',
        'variant_delete',
    ];

    const STATUSES = [
        'pending',
        'approved',
        'rejected',
        'need_more_info',
    ];

    public static function generateRequestNumber(): string
    {
        $prefix = 'REQ-';
        $lastRequest = self::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $lastRequest ? $lastRequest->id + 1 : 1;
        return $prefix . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(RequestCenterConversation::class, 'request_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(RequestCenterNotification::class, 'request_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeNeedMoreInfo($query)
    {
        return $query->where('status', 'need_more_info');
    }
}