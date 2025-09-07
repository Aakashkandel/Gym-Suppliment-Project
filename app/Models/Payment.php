<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'payment_method',
        'payment_status',
        'transaction_id',
        'gateway',
        'amount',
        'fee',
        'currency',
        'gateway_response',
        'notes',
        'paid_at',
        'failed_at',
        'refunded_at',
        'refunded_amount'
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the order that owns the payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that made the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for successful payments.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('payment_status', 'completed');
    }

    /**
     * Scope for pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope for failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    /**
     * Check if payment is successful.
     */
    public function getIsSuccessfulAttribute()
    {
        return $this->payment_status === 'completed';
    }

    /**
     * Check if payment is pending.
     */
    public function getIsPendingAttribute()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment failed.
     */
    public function getIsFailedAttribute()
    {
        return $this->payment_status === 'failed';
    }

    /**
     * Get net amount after fees.
     */
    public function getNetAmountAttribute()
    {
        return $this->amount - $this->fee;
    }
}
