<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

     protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function home()
{
    $brands = Brand::where('status', 1)->get(); // active brands

    return view('home', compact('brands'));
}
}
