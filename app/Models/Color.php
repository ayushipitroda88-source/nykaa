<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'color_code',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color');
    }
    public function variants()
{
    return $this->hasMany(ProductVariant::class);
}
}
