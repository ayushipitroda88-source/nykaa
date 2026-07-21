<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantSize extends Model
{
    protected $fillable = [
        'variant_id',
        'size_id',
        'price',
        'original_price',
        'quantity',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
}
