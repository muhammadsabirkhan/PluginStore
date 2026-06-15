<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 
        'discount_price', 'stock_quantity', 'sku', 'image', 'is_featured', 'rating'
    ];

    // Har product kisi ek category ka hissa hota hai
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Har product ke multiple reviews ho sakte hain
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}