<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size');
    }
    public function variants()
{
    return $this->hasMany(ProductVariant::class);
}
}
