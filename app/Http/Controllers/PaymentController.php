<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function esewasuccess(Request $request)
    {
        $data = $request->input('data');
        $decoded_data = json_decode(base64_decode($data), true);

        if (!$decoded_data) {
            return response()->json(['error' => 'Invalid data'], 400);
        }

        $transaction_code = $decoded_data['transaction_code'];
        $transaction_uuid = $decoded_data['transaction_uuid'];
        $total_amount = $decoded_data['total_amount'];
        $status = $decoded_data['status'];
        $product_code = $decoded_data['product_code'];
        $signed_field_names = $decoded_data['signed_field_names'];
        $signature = $decoded_data['signature'];

        $secret_key = '8gBm/:&EnhH.1/q';
        $data_string = "transaction_code={$transaction_code},status={$status},total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code},signed_field_names={$signed_field_names}";

    
        $hash = base64_encode(hash_hmac('sha256', $data_string, $secret_key, true));

       

        // if ($hash !== $signature) {
        //     return response()->json(['error' => 'Invalid signature'], 400);
        // }

        list($temp_id, $user_id) = explode('-', $transaction_uuid);

        // Get order data from session
        $order_data = session('pending_order_data');
        if (!$order_data) {
            return redirect()->route('esewa.fail')->with('error', 'Order data not found');
        }

        if ($status !== 'COMPLETE') {
            // Clear session data on failed payment
            session()->forget('pending_order_data');
            return redirect()->route('esewa.fail')->with('error', 'Payment not completed');
        }

        // Create order only after successful payment
        $order_data['status'] = 'pending';  // Start with pending status, admin will update to confirmed -> processing -> delivered
        $order_data['payment_status'] = 'paid';
        
        // Generate unique order number if not exists
        if (empty($order_data['order_number'])) {
            $order_data['order_number'] = Order::generateOrderNumber();
        }
        
        $order = Order::create($order_data);

        // Clear session data after successful order creation
        session()->forget('pending_order_data');

        $cart_ids = json_decode($order->cart_ids);
        if ($cart_ids && is_array($cart_ids)) {
            foreach ($cart_ids as $cart_id) {
                $cart = Cart::find($cart_id);
                
                if ($cart) {
                    $cart->status = 'paid';
                    $cart->visible = 0;
                    $cart->save();
                    
                    $product = Product::find($cart->product_id);
                    if ($product) {
                        $stock = $product->stock - $cart->quantity;
                        if ($stock < 0) {
                            $stock = 0;
                        }
                        $product->stock = $stock;
                        $product->save();
                    }
                }
            }
        }

        

        $paymentdata = [
            'order_id' => $order->id,
            'user_id' => $order->user_id, // Add the user_id from the order
            'transaction_id' => $transaction_code,
            'amount' => $total_amount,
            'payment_method' => 'esewa',
            'payment_status' => 'paid', // Normalize eSewa 'COMPLETE' to 'paid'
           
        ];

        Payment::create($paymentdata);
        return redirect()->route('user.orderhistory')->with('success', 'Payment successful');
    }

    public function esewafail(Request $request)
    {
        // Clear pending order data from session on payment failure
        session()->forget('pending_order_data');
        
        return redirect()->route('user.checkout')->with('error', 'Payment failed. Please try again.');
    }

    public function codPayment(Request $request)
    {
        $user_id = auth()->user()->id;
        $cart_items = Cart::where('user_id', $user_id)->where('visible', '1')->get();
        
        if ($cart_items->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'No items in cart');
        }

        $cart_ids = $cart_items->pluck('id')->toArray();
        $order_items = [];
        $total_amount = 0;
        
        foreach ($cart_items as $cart_item) {
            $product = Product::find($cart_item->product_id);
            if ($product) {
                $item_total = $product->price * $cart_item->quantity;
                $total_amount += $item_total;
                
                $order_items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $cart_item->quantity,
                    'unit_price' => $product->price,
                    'total_price' => $item_total,
                ];
            }
        }

        $user = auth()->user();
        $default_address = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'address' => $user->address ?? '',
        ];

        $orderData = [
            'user_id' => $user_id,
            'order_number' => Order::generateOrderNumber(),
            'cart_ids' => json_encode($cart_ids),
            'order_items' => json_encode($order_items),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cod',
            'total_amount' => $total_amount,
            'shipping_address' => json_encode($default_address),
            'billing_address' => json_encode($default_address),
            'order_date' => now(),
        ];

        $order = Order::create($orderData);

        foreach ($cart_ids as $cart_id) {
            $cart = Cart::find($cart_id);
            if ($cart) {
                $cart->visible = 0;
                $cart->save();
            }
        }

        $paymentData = [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_id' => 'COD-' . $order->order_number,
            'amount' => $total_amount,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
        ];

        Payment::create($paymentData);

        return redirect()->route('user.orderhistory')->with('success', 'COD order placed successfully.');
    }
}
