<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Decimal;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $cart_items = Cart::where('user_id', $user_id)->where('visible', '1')->get();
        $cart_ids = $cart_items->pluck('id')->toArray();
        

        // Validate the request data
        $data = $request->validate([
            'payment_method' => 'required',
            'total_amount' => 'required',
        ]);

      

        $data['user_id'] = $user_id;
        $data['cart_ids'] = json_encode($cart_ids);
        $data['status'] = 'pending';
        $data['payment_status'] = 'pending';
        $data['payment_method'] = $request->payment_method;
        $data['total_amount'] = $request->total_amount;
     
       
        $data['order_date'] = now();
        




        if ($data['payment_method'] == 'cod') {
            $data['status'] = 'completed';
            $od = Order::create($data);

            $cart_ids = json_decode($od->cart_ids);
            if ($cart_ids && is_array($cart_ids)) {
                foreach ($cart_ids as $cart_id) {
                    $cart = Cart::find($cart_id);
                    
                    if ($cart) {
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
            return redirect()->route('user.orderhistory')->with('success', 'Order placed successfully');

        } else {
            // Store order data in session instead of creating order immediately
            session(['pending_order_data' => $data]);

            try {
                $product_code = 'EPAYTEST';
                $amount = $request->price;
                $tax_amount = 0;
                $service_charge = 0;
                $delivery_charge = 0;
                $total_amount = $amount + $tax_amount + $service_charge + $delivery_charge;
                $success_url = route('esewa.success');
                $failure_url = route('esewa.fail');
                // Use timestamp as temporary ID since we haven't created order yet
                $temp_id = time();
                $transaction_uuid = $temp_id . '-' . $user_id;
                $signed_field_names = 'total_amount,transaction_uuid,product_code';
                $secret_key = '8gBm/:&EnhH.1/q';

                $data_string = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";

                $signature = base64_encode(hash_hmac('sha256', $data_string, $secret_key, true));

                return response()->json([
                    'product_code' => $product_code,
                    'amount' => $amount,
                    'tax_amount' => $tax_amount,
                    'service_charge' => $service_charge,
                    'delivery_charge' => $delivery_charge,
                    'total_amount' => $total_amount,
                    'success_url' => $success_url,
                    'failure_url' => $failure_url,
                    'transaction_uuid' => $transaction_uuid,
                    'signed_field_names' => $signed_field_names,
                    'signature' => $signature,
                ])->withHeaders([
                    'Content-Type' => 'text/html'
                ])->setStatusCode(200)->setContent(
                    '<html><body>' .
                        '<form id="esewaForm" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">' .
                        '<input type="hidden" name="amount" value="' . $amount . '">' .
                        '<input type="hidden" name="tax_amount" value="' . $tax_amount . '">' .
                        '<input type="hidden" name="total_amount" value="' . $total_amount . '">' .
                        '<input type="hidden" name="transaction_uuid" value="' . $transaction_uuid . '">' .
                        '<input type="hidden" name="product_code" value="' . $product_code . '">' .
                        '<input type="hidden" name="product_service_charge" value="' . $service_charge . '">' .
                        '<input type="hidden" name="product_delivery_charge" value="' . $delivery_charge . '">' .
                        '<input type="hidden" name="esewa_service_charge" value="0">' .
                        '<input type="hidden" name="merchant_service_fee" value="0">' .
                        '<input type="hidden" name="success_url" value="' . $success_url . '">' .
                        '<input type="hidden" name="failure_url" value="' . $failure_url . '">' .
                        '<input type="hidden" name="signed_field_names" value="' . $signed_field_names . '">' .
                        '<input type="hidden" name="signature" value="' . $signature . '">' .
                        '</form>' .
                        '<script>document.getElementById("esewaForm").submit();</script>' .
                        '</body></html>'
                );
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'Order placed successfully'], 200);
    }

   

    public function history()
    {
        $user=auth()->user()->id;
       
        $orders = Order::where('user_id', $user)->orderBy('id', 'desc')->get();
        
        $items=$orders->pluck('cart_ids');
     
        return view('user.orderhistory', compact('orders'));

    }

    public function orderproduct($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('user.orderhistory')->with('error', 'Order not found');
        }

        // Ensure the order belongs to the authenticated user
        if (auth()->check() && $order->user_id !== auth()->user()->id) {
            return redirect()->route('user.orderhistory')->with('error', 'Unauthorized access to order');
        }

        $cart_ids = json_decode($order->cart_ids);
        
        if (!$cart_ids || !is_array($cart_ids)) {
            return redirect()->route('user.orderhistory')->with('error', 'No items found in this order');
        }

        // Get cart items with product information
        $cart_items = Cart::with('product')
            ->whereIn('id', $cart_ids)
            ->get();

        if ($cart_items->isEmpty()) {
            return redirect()->route('user.orderhistory')->with('error', 'Order items not found');
        }

        // Calculate order summary
        $orderSummary = [
            'total_items' => $cart_items->sum('quantity'),
            'total_products' => $cart_items->count(),
            'total_amount' => $cart_items->sum(function($item) {
                return $item->quantity * $item->price;
            })
        ];

        return view('user.orderproduct', compact('cart_items', 'order', 'orderSummary'));
    }

    public function cancleorder($id){
            
            $order = Order::find($id);
            
            if (!$order) {
                return redirect()->route('user.orderhistory')->with('fail', 'Order not found');
            }
            
            $cart_ids = json_decode($order->cart_ids);
            
            if ($cart_ids && is_array($cart_ids)) {
                foreach ($cart_ids as $cart_id) {
                    $cart = Cart::find($cart_id);
                    
                    if ($cart) {
                        // Restore product stock
                        if ($cart->product) {
                            $productstock = $cart->product->stock + $cart->quantity;
                            $cart->product->stock = $productstock;
                            $cart->product->save();
                        }
                        
                        // Delete the cart item
                        $cart->delete();
                    }
                }
            }
            
            $order->delete();
            return redirect()->route('user.orderhistory')->with('success', 'Order cancelled successfully');
            

    }

    public function deleteorder($id)
    {
        $order = Order::find($id);
        
        if (!$order) {
            return redirect()->route('user.orderhistory')->with('fail', 'Order not found');
        }
        
        $cart_ids = json_decode($order->cart_ids);
        
        if ($cart_ids && is_array($cart_ids)) {
            foreach ($cart_ids as $cart_id) {
                $cart = Cart::find($cart_id);
                
                if ($cart) {
                    $cart->delete();
                }
            }
        }
        
        $order->delete();
        return redirect()->route('user.orderhistory')->with('success', 'Order deleted successfully');
    }



}
