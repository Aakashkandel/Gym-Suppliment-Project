@extends('layouts.usermenu')
@section('content')

<div class="bg-gradient-to-br from-emerald-50 to-teal-50 min-h-screen py-8 px-4">
    <div class="container mx-auto mt-12">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('user.index') }}" class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Product Details</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <!-- Product Details Card -->
        <div class="flex flex-col lg:flex-row bg-white shadow-2xl rounded-2xl overflow-hidden border border-emerald-100">
            <div class="lg:w-1/2 relative group">
                <img class="object-cover w-full h-full md:h-full transition-transform duration-300 group-hover:scale-105" src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            <div class="lg:w-1/2 p-8 flex flex-col justify-between">
                <form action="{{ route('productdetails.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <div class="space-y-4">
                        <h2 class="text-4xl font-bold text-gray-800 leading-tight">{{ $product->name }}</h2>
                        <h3 class="text-xl text-emerald-600 font-medium">{{ $product->title }}</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">{{ $product->description }}</p>
                    </div>

                    <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-3xl font-bold text-emerald-700">Rs {{ number_format($product->price) }}</span>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-emerald-700 font-semibold">{{ $product->stock }} in stock</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label for="quantity" class="block text-gray-700 font-semibold text-lg">Quantity</label>
                        <div class="flex items-center space-x-3">
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" 
                                   class="w-24 px-4 py-3 border-2 border-emerald-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-center font-semibold">
                            <span class="text-gray-500">of {{ $product->stock }} available</span>
                        </div>
                        @error('quantity')
                        <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                            </svg>
                            Add to Cart
                        </button>
                        <a href="{{ route('user.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 rounded-xl transition duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Back to Home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
