@extends('layouts.usermenu')
@section('content')

<section class="relative bg-gray-900 text-white min-h-[100vh] flex items-center" style="background-image: url('{{ asset('clientimage/gym_herosection.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="hero-overlay"></div>

    <div class="container mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <span class="inline-block bg-yellow-400 text-black px-3 py-1 rounded-full mb-4">Trusted • Fast Delivery • Authentic</span>
            <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight">Premium Supplements For Your Fitness Journey</h1>
            <p class="text-gray-300 mt-4 text-lg">Genuine gym supplements for strength, recovery and peak performance — delivered fast and guaranteed authentic.</p>

            <div class="flex flex-wrap gap-3 mt-6">
                <a href="{{ route('user.shop') }}" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg text-white font-semibold">Shop Now</a>
                <a href="#categories" class="border border-white/60 hover:bg-white hover:text-black px-6 py-3 rounded-lg font-semibold">Browse Categories</a>
            </div>

            <div class="flex gap-5 mt-8">
                <div class="bg-white/10 px-5 py-3 rounded-xl min-w-[120px]">
                    <div class="text-2xl font-bold">{{$totalUsers ?? '15'}}K+</div>
                    <p class="text-gray-300 text-sm">Happy Customers</p>
                </div>
                <div class="bg-white/10 px-5 py-3 rounded-xl min-w-[120px]">
                    <div class="text-2xl font-bold">{{$totalProducts ?? count($latestproducts) ?? '120'}}+</div>
                    <p class="text-gray-300 text-sm">Supplements</p>
                </div>
            </div>
        </div>

       
    </div>
</section>



<section class="container mx-auto px-6 py-12" id="categories">
    <h2 class="text-3xl font-bold mb-6">Our Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($latestproducts as $item)
        <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">
            <a href="{{ route('user.productdetails', $item->id) }}" class="block">
                <img src="{{ asset('images/'.$item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-contain bg-gray-100 rounded-lg">
            </a>
            <h3 class="mt-3 font-semibold text-lg">{{ $item->name }}</h3>
            <p class="text-gray-600">Rs. {{ $item->price }}</p>

                <div class="mt-3 grid grid-cols-2 gap-3">
                <a href="{{ route('user.productdetails', $item->id) }}" class="text-center px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">View Details</a>
                @auth
                <form method="POST" action="{{ route('productdetails.store') }}" class="m-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{ $item->price }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-black">Add to Cart</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="w-full inline-block text-center bg-gray-900 text-white py-2 rounded-lg hover:bg-black">Add to Cart</a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</section>

<div class="container mx-auto px-4 py-8">
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-2" style="border-color: var(--secondary-color);">
                <i class="fas fa-shipping-fast text-4xl mb-4" style="color: var(--primary-color);"></i>
                <h3 class="text-xl font-bold mb-2" style="color: var(--primary-color);">Fast Delivery</h3>
                <p class="text-gray-600">Quick delivery to fuel your fitness goals</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-2" style="border-color: var(--secondary-color);">
                <i class="fas fa-certificate text-4xl mb-4" style="color: var(--primary-color);"></i>
                <h3 class="text-xl font-bold mb-2" style="color: var(--primary-color);">Lab Tested</h3>
                <p class="text-gray-600">Premium supplements tested for purity and potency</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-2" style="border-color: var(--secondary-color);">
                <i class="fas fa-user-md text-4xl mb-4" style="color: var(--primary-color);"></i>
                <h3 class="text-xl font-bold mb-2" style="color: var(--primary-color);">Expert Advice</h3>
                <p class="text-gray-600">24/7 support from certified fitness professionals</p>
            </div>
        </div>
    </div>
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Why Choose Us?</h2>

        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="p-6 bg-white shadow rounded-xl">
                <h3 class="text-xl font-bold mb-2">100% Authentic Products</h3>
                <p class="text-gray-600">Guaranteed original supplements sourced directly from trusted distributors.</p>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                <h3 class="text-xl font-bold mb-2">Fast Delivery</h3>
                <p class="text-gray-600">Quick and safe delivery all over Nepal with real-time order tracking.</p>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                <p class="text-gray-600">Premium quality supplements at affordable and competitive prices.</p>
            </div>
        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <img src="{{ asset('clientimage/gym1.webp') }}"
            class="w-full rounded-2xl shadow-xl h-[380px] object-cover">

        <div>
            <h2 class="text-3xl font-bold mb-4">About Online Gym Supplements</h2>
            <p class="text-gray-700 leading-relaxed">
                Online Gym Supplements is Nepal’s trusted destination for premium gym supplements.
                Our mission is to provide athletes, bodybuilders and fitness lovers with the highest
                quality nutrition products to maximize their performance.
            </p>
            <p class="mt-3 text-gray-700">
                We focus on authenticity, fast delivery and complete customer satisfaction.
                Your fitness goals are our priority.
            </p>
        </div>
    </div>
</section>



@endsection
