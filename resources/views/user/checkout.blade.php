@extends('layouts.usermenu')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Billing Information -->

        <form action="{{ route('order.store') }}" method="POST" class="w-full lg:w-3/5 bg-white shadow-lg rounded-lg p-6">
        @csrf
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Billing Information</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                   
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" value="{{auth()->user()->name}}" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                   
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value={{auth()->user()->email}} id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    @error('address')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="city" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    @error('city')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="w-full bg-gray-50 shadow-md rounded-lg mt-6 p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Payment Details</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="cod" name="payment_method" type="radio" value="cod" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery</label>
                    </div>
                    <div class="flex items-center">
                        <input id="esewa" name="payment_method" type="radio" value="esewa" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" >
                        <label for="esewa" class="ml-3 block text-sm font-medium text-gray-700">eSewa Wallet</label>
                    </div>
                    <div id="esewa-details" class="mt-4">
                        <img src="{{ asset('clientimage/esewa.png') }}" alt="eSewa Logo" class="h-auto w-28">
                    </div>
                    <input type="hidden" name="price" value="{{$total}}">
                </div>
                @error('payment_method')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <input type="hidden" name="total_amount" value="{{ $total }}">

            <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">Place Order</button>
        </form>

        <!-- Order Summary -->
        <div class="w-full lg:w-2/5 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Order Summary</h2>
            <div class="space-y-2 text-gray-800">
                <div class="flex justify-between">
                    <span>Total Items:</span>
                    <span>{{ $items }} items</span>
                </div>
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>Rs {{ $total }}</span>
                   
                </div>
                <div class="flex justify-between">
                    <span>Tax:</span>
                    <span>Rs 0</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping:</span>
                    <span>Rs 0</span>
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <div class="flex justify-between text-xl font-semibold">
                    <span>Total:</span>
                    <span>Rs {{ $total }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
