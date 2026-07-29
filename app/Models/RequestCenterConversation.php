<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestCenterConversation extends Model
{
    protected $table = 'request_center_conversations';

    protected $fillable = [
        'request_id',
        'seller_id',
        'admin_id',
        'message',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(RequestCenterRequest::class, 'request_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}