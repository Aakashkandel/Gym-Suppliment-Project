@extends('layouts.usermenu')
@section('content')

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Shopping Cart</h1>



        <div class="flex flex-col lg:flex-row justify-between">
            <!-- Cart Items -->
            <div class="w-full lg:w-3/4  bg-blue-100 rounded-lg shadow p-6 overflow-auto max-h-full">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Items in your cart</h2>
                @if ($errors->has('quantity'))
                <h2 class=" text-right font-semibold text-red-500 px-5 py-2 rounded-xl">
                    {{ $errors->first('quantity') }}
                </h2>
                @endif
                <?php      $total=0; ?>

                @foreach($carts as $cart)

               
           
                <div class="flex items-center justify-between mb-4 border-b pb-4 bg-gray-100 p-5 rounded-xl">
                    <div class="flex items-center">
                        <img src="{{asset('/images/product/'.$cart->product->image)}}" alt="Product Image" class="w-20 h-20 rounded">
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{$cart->product->name}}</h3>
                            <p class="text-gray-600">{{$cart->product->category->name}}</p>
                            <p class="font-semibold text-green-700">Stock: {{$cart->product->stock}}</p>
                        </div>
                    </div>
                    <div class="flex items-center">

                        <div class="mr-4">

                            <form action="{{route('user.cart.update',$cart->id)}}" method="post">
                                @csrf
                                <input type="number" value="{{$cart->quantity}}" name="quantity" class="w-16 p-2 border rounded text-center">

                                <button type="submit" class="text-gray-100 mx-5 bg-green-900  px-5 py-1 rounded-xl hover:text-gray-200">Update</button>
                            </form>

                        </div>
                        <div class="text-lg font-semibold text-gray-800">
                            Rs {{$cart->product->price * $cart->quantity}}
                        </div>
                    </div>
                    <div>

                    </div>
                    <a href="{{route('user.cart.destroy',$cart->id)}}"> <button class="text-red-500 hover:text-red-700">Remove</button></a>

                </div>

                @php
                $total=$total+$cart->product->price*$cart->quantity
                
                @endphp
                @endforeach

                @if(count($carts)==0)
                <h2 class="text-2xl font-bold mb-4 text-center text-gray-700">No Items in your cart</h2>
                @endif
            </div>

            <!-- Summary Section -->
            <div class="w-full lg:w-1/4 bg-blue-100 rounded-lg shadow p-6 mt-6 lg:mt-0 lg:ml-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Summary</h2>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-800">{{$total}}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="text-gray-800">Rs 0</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-gray-600">Taxes</span>
                    <span class="text-gray-800">Rs 0</span>
                </div>
                <div class="border-t pt-4 flex justify-between font-bold">
                    <span class="text-gray-800">Total</span>
                    <span class="text-gray-800">Rs <?php echo $total; ?></span>
                </div>
               <a href="{{route('user.checkout')}}"> <button class="w-full bg-green-600 text-white py-2 mt-6 rounded hover:bg-green-500">Proceed to Checkout</button></a>
                <div class="text-center mt-4">
                    <a href="{{route('user.shop')}}" class="text-blue-500 hover:text-blue-700">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>

</body>
@endsection