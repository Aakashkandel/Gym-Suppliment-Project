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
