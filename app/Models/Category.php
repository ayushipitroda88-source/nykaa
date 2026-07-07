<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'position',
        'status',
        'image',
        'description',
        'price',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
                     // @phpstan-ignore-next-line
                     ->orderBy('position');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isLeaf()
    {
        return $this->children()->count() === 0;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

   
}
