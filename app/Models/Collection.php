<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
         'slug',
        'description',
        'image',
        'status',
        'discount',
        'discount_start',
        'discount_end'
    ];

    

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    
}
