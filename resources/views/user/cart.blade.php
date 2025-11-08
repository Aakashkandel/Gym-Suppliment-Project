@extends('layouts.usermenu')
@section('content')

<div class="bg-gradient-to-br from-emerald-50 to-teal-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Shopping Cart</h1>
            <p class="text-gray-600">Review your items before checkout</p>
        </div>

        <!-- Error Message -->
        @if ($errors->has('quantity'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">{{ $errors->first('quantity') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                            </svg>
                            Cart Items ({{ count($carts) }})
                        </h2>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <?php $total = 0; ?>
                        
                        @forelse($carts as $cart)
                        <div class="flex items-center justify-between p-6 mb-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center flex-1">
                                <div class="relative">
                                    
                                    <img src="{{asset('images/'.$cart->product->image)}}" alt="{{$cart->product->name}}" class="w-20 h-20 rounded-xl object-cover shadow-md">
                                    <div class="absolute -top-2 -right-2 bg-emerald-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
                                        {{ $cart->quantity }}
                                    </div>
                                </div>
                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{$cart->product->name}}</h3>
                                    <p class="text-emerald-600 font-medium mb-1">{{$cart->product->category->name}}</p>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-green-600 font-semibold text-sm">{{$cart->product->stock}} in stock</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <form action="{{route('user.cart.update',$cart->id)}}" method="post" class="flex items-center space-x-3">
                                    @csrf
                                    <div class="flex items-center bg-white rounded-lg border-2 border-emerald-200">
                                        <input type="number" value="{{$cart->quantity}}" name="quantity" min="1" max="{{$cart->product->stock}}" 
                                               class="w-16 p-2 text-center font-semibold bg-transparent border-none focus:outline-none focus:ring-0">
                                    </div>
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 shadow-md">
                                        Update
                                    </button>
                                </form>
                                
                                <div class="text-right">
                                    <div class="text-xl font-bold text-gray-800">
                                        Rs {{number_format($cart->product->price * $cart->quantity)}}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Rs {{number_format($cart->product->price)}} each
                                    </div>
                                </div>
                                
                                <a href="{{route('user.cart.destroy',$cart->id)}}" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        @php
                        $total = $total + $cart->product->price * $cart->quantity
                        @endphp
                        @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="text-2xl font-medium text-gray-400 mb-2">Your cart is empty</h3>
                            <p class="text-gray-500 mb-6">Start shopping to add items to your cart</p>
                            <a href="{{route('user.shop')}}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Start Shopping
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="lg:w-96">
                <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                            Order Summary
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Subtotal</span>
                            <span class="text-gray-800 font-bold">Rs {{number_format($total)}}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Shipping</span>
                            <span class="text-green-600 font-bold">Free</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Taxes</span>
                            <span class="text-gray-800 font-bold">Rs 0</span>
                        </div>
                        <div class="border-t-2 border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-emerald-600">Rs {{number_format($total)}}</span>
                            </div>
                        </div>
                        
                        @if(count($carts) > 0)
                        <div class="space-y-3 pt-4">
                            <a href="{{route('user.checkout')}}" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white py-4 rounded-xl font-bold transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Proceed to Checkout
                            </a>
                            <a href="{{route('user.shop')}}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold transition duration-200 text-center block">
                                Continue Shopping
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection