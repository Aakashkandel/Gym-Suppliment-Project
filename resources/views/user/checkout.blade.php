@extends('layouts.usermenu')
@section('content')
<div class="bg-gradient-to-br from-emerald-50 to-teal-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Checkout</h1>
            <p class="text-gray-600">Complete your order securely</p>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                    <span class="ml-2 text-emerald-600 font-medium">Cart</span>
                </div>
                <div class="w-8 h-1 bg-emerald-600"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                    <span class="ml-2 text-emerald-600 font-medium">Checkout</span>
                </div>
                <div class="w-8 h-1 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-bold text-sm">3</div>
                    <span class="ml-2 text-gray-500 font-medium">Complete</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Billing Information -->
            <div class="flex-1">
                <form action="{{ route('order.store') }}" method="POST" class="bg-white shadow-2xl rounded-2xl border border-emerald-100 overflow-hidden">
                    @csrf
                    
                    <!-- Billing Information Section -->
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Billing Information
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-gray-700">Full Name</label>
                                <input type="text" value="{{auth()->user()->name}}" id="name" name="name" 
                                       class="w-full px-4 py-3 border-2 border-emerald-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                                @error('name')
                                    <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-bold text-gray-700">Email Address</label>
                                <input type="email" value="{{auth()->user()->email}}" id="email" name="email" 
                                       class="w-full px-4 py-3 border-2 border-emerald-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                                @error('email')
                                    <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="address" class="block text-sm font-bold text-gray-700">Address</label>
                                <input type="text" id="address" name="address" placeholder="Street address, P.O. Box, etc." 
                                       class="w-full px-4 py-3 border-2 border-emerald-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                                @error('address')
                                    <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="city" class="block text-sm font-bold text-gray-700">City</label>
                                <input type="text" id="city" name="city" placeholder="Your city" 
                                       class="w-full px-4 py-3 border-2 border-emerald-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                                @error('city')
                                    <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="border-t border-emerald-100">
                        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 p-6">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                </svg>
                                Payment Method
                            </h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="space-y-4">
                                <div class="flex items-center p-4 border-2 border-emerald-200 rounded-xl hover:bg-emerald-50 transition duration-200">
                                    <input id="cod" name="payment_method" type="radio" value="cod" class="h-5 w-5 text-emerald-600 border-emerald-300 focus:ring-emerald-500">
                                    <label for="cod" class="ml-4 flex items-center cursor-pointer flex-1">
                                        <div class="bg-emerald-100 p-2 rounded-lg mr-3">
                                            <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h8zM6 10a1 1 0 011-1h1a1 1 0 110 2H7a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2h-1z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold text-gray-800">Cash on Delivery</div>
                                            <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center p-4 border-2 border-emerald-200 rounded-xl hover:bg-emerald-50 transition duration-200">
                                    <input id="esewa" name="payment_method" type="radio" value="esewa" class="h-5 w-5 text-emerald-600 border-emerald-300 focus:ring-emerald-500">
                                    <label for="esewa" class="ml-4 flex items-center cursor-pointer flex-1">
                                        <div class="bg-white p-2 rounded-lg mr-3 border">
                                            <img src="{{ asset('clientimage/esewa.png') }}" alt="eSewa Logo" class="h-8 w-auto">
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold text-gray-800">eSewa Wallet</div>
                                            <div class="text-sm text-gray-600">Pay using your eSewa digital wallet</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            @error('payment_method')
                                <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                            @enderror
                            
                            <input type="hidden" name="price" value="{{$total}}">
                            <input type="hidden" name="total_amount" value="{{ $total }}">
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <div class="p-6 bg-gray-50">
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white py-4 px-6 rounded-xl font-bold text-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Place Order Securely
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-96">
                <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 p-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Order Summary
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-200">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-700 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                    </svg>
                                    Total Items
                                </span>
                                <span class="text-gray-800 font-bold">{{ $items }} items</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Subtotal</span>
                                <span class="text-gray-800 font-bold">Rs {{ number_format($total) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Tax</span>
                                <span class="text-green-600 font-bold">Rs 0</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Shipping</span>
                                <span class="text-green-600 font-bold">Free</span>
                            </div>
                        </div>
                        
                        <div class="border-t-2 border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-800">Total Amount</span>
                                <span class="text-2xl font-bold text-emerald-600">Rs {{ number_format($total) }}</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-4 border border-emerald-200 mt-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-emerald-700 text-sm font-medium">Secure checkout guaranteed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
