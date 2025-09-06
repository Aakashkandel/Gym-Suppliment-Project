<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order that contains this cart item.
     */
    public function order()
    {
        return Order::whereJsonContains('cart_ids', $this->id)->first();
    }

    /**
     * Scope for visible cart items.
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Get total price for this cart item.
     */
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
