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
            foreach ($cart_ids as $cart_id) {
                $cart = Cart::find($cart_id);
                $cart->visible = 0;
                $cart->save();
                $product = Product::find($cart->product_id);
                $stock = $product->stock - $cart->quantity;
                if ($stock < 0) {
                    $stock = 0;
                }
                $product->stock = $stock;
                $product->save();
            }
            return redirect()->route('user.orderhistory')->with('success', 'Order placed successfully');

        } else {
            $order = Order::create($data);

            try {
                $product_code = 'EPAYTEST';
                $amount = $request->price;
                $tax_amount = 0;
                $total_amount = $amount + $tax_amount;
                $success_url = route('esewa.success');
                $failure_url = route('esewa.fail');
                $transaction_uuid = $order->id . '-' . time();
                $signed_field_names = 'total_amount,transaction_uuid,product_code';
                $secret_key = '8gBm/:&EnhH.1/q';

                $data_string = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";

                $signature = base64_encode(hash_hmac('sha256', $data_string, $secret_key, true));

                return response()->json([
                    'product_code' => $product_code,
                    'amount' => $amount,
                    'tax_amount' => $tax_amount,
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
                        '<input type="hidden" name="product_service_charge" value="0">' .
                        '<input type="hidden" name="product_delivery_charge" value="0">' .
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

    
    $cart_ids = json_decode($order->cart_ids);

    
    $cart_items = Cart::whereIn('id', $cart_ids)->get();



   


    return view('user.orderproduct', compact('cart_items'));
        

        
    }

    public function cancleorder($id){
            
            $order = Order::find($id);
            $cart_ids = json_decode($order->cart_ids);
            foreach ($cart_ids as $cart_id) {
                $cart = Cart::find($cart_id);
                $cart->visible = 0;
                $productstock=$cart->product->stock + $cart->quantity;
                $cart->product->stock=$productstock;
                $cart->product->save();
                $cart->delete();
            }
            $order->delete();
            return redirect()->route('user.orderhistory')->with('success', 'Order cancelled successfully');
            

    }

    public function deleteorder($id)
    {

        $order = Order::find($id);
        $cart_ids = json_decode($order->cart_ids);
        foreach ($cart_ids as $cart_id) {
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        $order->delete();
        return redirect()->route('user.orderhistory')->with('success', 'Order cancelled successfully');

    }



}
