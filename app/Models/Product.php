<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'category_id',
        'brand_id',
        'price',
        'quantity',
        'seller_id',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function collections()
{
    return $this->belongsToMany(Collection::class);
}

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

public function getDiscountedPrice($collectionId = null)
{
    $price = $this->price;

    if ($collectionId) {

        $collection = $this->collections()
            ->where('collections.id', $collectionId)
            ->first();

        if (
            $collection &&
            $collection->discount > 0 &&
            now()->between($collection->discount_start, $collection->discount_end)
        ) {

            $price = $price - ($price * $collection->discount / 100);
        }
    }

    return round($price, 2);
}
public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

}
