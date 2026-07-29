<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'order_item_id',
        'rating',
        'title',
        'description',
        'status',
        'rejection_reason',
        'is_verified_purchase',
        'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'helpful_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }

    public function reply()
    {
        return $this->hasOne(ReviewReply::class);
    }

    public function helpfulVotes()
    {
        return $this->hasMany(ReviewHelpful::class);
    }

    public function reports()
    {
        return $this->hasMany(ReviewReport::class);
    }

    public function isHelpfulBy($userId)
    {
        if (!$userId) return false;
        return $this->helpfulVotes()->where('user_id', $userId)->exists();
    }
}
