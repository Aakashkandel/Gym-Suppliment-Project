<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id', 
        'cart_ids',
        'order_items',
        'status', 
        'payment_status',
        'payment_method',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'shipping_address',
        'billing_address',
        'tracking_number',
        'courier_service',
        'shipped_at',
        'delivered_at',
        'delivery_notes',
        'order_date',
        'internal_notes'
    ];

    protected $casts = [
        'cart_ids' => 'array',
        'order_items' => 'array',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'order_date' => 'date',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payments for the order.
     */
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
        if ($this->delivered_at) {
            return $this->created_at->diffInDays($this->delivered_at);
        }
        return $this->created_at->diffInDays(now());
    }

    /**
     * Get the latest payment for this order.
     */
    public function getLatestPaymentAttribute()
    {
        return $this->payments()->latest()->first();
    }

    /**
     * Get total paid amount.
     */
    public function getTotalPaidAmountAttribute()
    {
        return $this->payments()->where('payment_status', 'completed')->sum('amount');
    }

    /**
     * Check if order is fully paid.
     */
    public function getIsFullyPaidAttribute()
    {
        return $this->total_paid_amount >= $this->total_amount;
    }

    /**
     * Get payment status based on payments.
     */
    public function getPaymentStatusAttribute()
    {
        if ($this->is_fully_paid) {
            return 'paid';
        }
        
        $latestPayment = $this->latest_payment;
        if ($latestPayment) {
            return $latestPayment->payment_status;
        }
        
        return 'pending';
    }

    /**
     * Get remaining amount to be paid.
     */
    public function getRemainingAmountAttribute()
    {
        return max(0, $this->total_amount - $this->total_paid_amount);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Boot function to auto-generate order number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }
}
