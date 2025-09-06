<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts=Cart::where('user_id',auth()->user()->id)->where('visible',1)->get();
   
        return view('user.cart',compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $product=Product::find($request->product_id);

       
        
        $data=$request->validate([
            'product_id'=>'required',
            'quantity'=>'required|numeric|min:1|max:'.$product->stock,
            'price'=>'required',
            'user_id'=>'required',
            


        ]);
        $carts=Cart::where('user_id',auth()->user()->id)->where('visible',1)->get();
        foreach($carts as $cart)
        {
           
        
            if($cart->user_id==$request->user_id && $cart->product_id==$request->product_id)
            {
               
             
                return redirect()->route('user.cart')->with('fail','Product added to cart successfully');
               

            }
        }
        $cart=Cart::create($data);
        return redirect()->route('user.cart')->with('success','Product added to cart successfully');

        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $cart=Cart::find($id);
    

        $data=$request->validate([
            'quantity'=>'required|numeric|min:1|max:'.$cart->product->stock,
            
        ]);

        $cart->update($data);

        return redirect()->route('user.cart')->with('success','Quantity updated Successfully');
    
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Cart::find($id);
        $data->delete();
        return redirect()->route('user.cart')->with('success','Cart Removed Successfully');
    }
}
