@extends('layouts.usermenu')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 p-4 pt-20">
    @foreach($cart_items as $cart)
    <div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform transform hover:scale-105">
        <img src="{{ asset('images/product/' . $cart->product->image) }}" class="w-full h-48 object-cover" alt="{{ $cart->product->name }}">
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800">{{ $cart->product->name }}</h3>
            <p class="text-gray-600 mt-2">Rs {{ number_format($cart->product->price, 2) }}</p>
            <p class="text-gray-600 mt-2">Quantity: <span class="font-bold  text-yellow-800"> {{ $cart->quantity }}</span> </p>
            <p class="text-gray-200 mt-2 p-1 bg-green-600 rounded font-semibold ">Total: Rs {{ number_format($cart->price*$cart->quantity, 2) }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection
