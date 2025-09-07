<?php

require_once 'vendor/autoload.php';

use App\Models\Order;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Product;

// Test payment cycle completion
echo "=== Payment Cycle Test ===\n\n";

try {
    // Test eSewa payment completion
    echo "1. Testing eSewa payment completion...\n";
    $esewaOrders = Order::where('payment_method', 'esewa')->where('payment_status', 'paid')->get();
    echo "eSewa paid orders: " . $esewaOrders->count() . "\n";
    
    // Test COD orders
    echo "\n2. Testing COD orders...\n";
    $codOrders = Order::where('payment_method', 'cod')->get();
    echo "COD orders: " . $codOrders->count() . "\n";
    
    foreach ($codOrders as $order) {
        echo "Order #{$order->order_number}: Status={$order->status}, Payment={$order->payment_status}\n";
    }
    
    // Test payment records
    echo "\n3. Testing payment records...\n";
    $payments = Payment::all();
    echo "Total payments: " . $payments->count() . "\n";
    
    foreach ($payments as $payment) {
        echo "Payment ID {$payment->id}: Method={$payment->payment_method}, Status={$payment->payment_status}, Amount={$payment->amount}\n";
    }
    
    // Test order statuses
    echo "\n4. Order status breakdown...\n";
    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    foreach ($statuses as $status) {
        $count = Order::where('status', $status)->count();
        echo "Status '{$status}': {$count} orders\n";
    }
    
    echo "\n=== Test completed successfully! ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
