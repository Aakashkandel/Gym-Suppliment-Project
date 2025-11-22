<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'additional_images' => 'array',
        'tags' => 'array',
        'flavors' => 'array',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'weight' => 'decimal:3',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Get main product image
    public function getMainImageAttribute()
    {
        // Prefer images array if present
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            $img = $this->images[0];
            // If the stored value is already a full path or starts with 'images/', return asset of that path
            if (Str::startsWith($img, ['http://', 'https://'])) {
                return $img;
            }
            if (Str::startsWith($img, 'images/')) {
                return asset($img);
            }
            return asset('images/product/' . $img);
        }

        if ($this->image) {
            $img = $this->image;
            if (Str::startsWith($img, ['http://', 'https://'])) {
                return $img;
            }
            if (Str::startsWith($img, 'images/')) {
                return asset($img);
            }
            return asset('images/product/' . $img);
        }

        return asset('images/placeholder.jpg');
    }

    // Get discounted price
    public function getDiscountedPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Check if product has discount
    public function getHasDiscountAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }
}
