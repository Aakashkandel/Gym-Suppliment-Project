<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'cart_ids', 
        'status', 
        'payment_method', 
        'payment_status', 
        'order_date',
        'total_amount',
        'delivery_date',
        'tracking_number',
        'notes'
    ];

    protected $casts = [
        'cart_ids' => 'array',
        'order_date' => 'date',
        'delivery_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get cart items for this order.
     */
    public function carts()
    {
        if ($this->cart_ids) {
            return Cart::with('product')->whereIn('id', $this->cart_ids)->get();
        }
        return collect();
    }

    /**
     * Get total items count in the order.
     */
    public function getItemsAttribute()
    {
        if ($this->cart_ids) {
            $cart_ids = is_array($this->cart_ids) ? $this->cart_ids : json_decode($this->cart_ids, true);
            if ($cart_ids && is_array($cart_ids)) {
                return Cart::whereIn('id', $cart_ids)->sum('quantity');
            }
        }
        return 0;
    }

    /**
     * Get total products count (unique products) in the order.
     */
    public function getProductsCountAttribute()
    {
        if ($this->cart_ids) {
            $cart_ids = is_array($this->cart_ids) ? $this->cart_ids : json_decode($this->cart_ids, true);
            if ($cart_ids && is_array($cart_ids)) {
                return Cart::whereIn('id', $cart_ids)->count();
            }
        }
        return 0;
    }

    /**
     * Scope for pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processing orders.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope for shipped orders.
     */
    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    /**
     * Scope for delivered orders.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope for paid orders.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Get payment status badge color.
     */
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'paid' => 'green',
            'failed' => 'red',
            'rejected' => 'red'
        ];

        return $colors[$this->payment_status] ?? 'gray';
    }

    /**
     * Check if order can be cancelled.
     */
    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Get order duration.
     */
    public function getOrderDurationAttribute()
    {
        if ($this->delivery_date) {
            return $this->created_at->diffInDays($this->delivery_date);
        }
        return $this->created_at->diffInDays(now());
    }
}
