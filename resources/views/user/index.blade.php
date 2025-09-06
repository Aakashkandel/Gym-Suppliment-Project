@extends('layouts.usermenu')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body class="bg-gray-50 text-gray-900">

<style>
:root {
    --primary-color: #2C3E50 !important;
    --primary-light: #34495e !important;
    --primary-dark: #1a252f !important;
    --secondary-color: #F39C12 !important;
    --secondary-light: #f4a62a !important;
    --secondary-dark: #d68910 !important;
}

* {
    --tw-bg-opacity: 1 !important;
}

.hero-bg {
    background: linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%) !important;
}

body .text-primary { color: #2C3E50 !important; }
body .text-secondary { color: #F39C12 !important; }
body .bg-primary { background-color: #2C3E50 !important; }
body .bg-secondary { background-color: #F39C12 !important; }
body .border-primary { border-color: #2C3E50 !important; }
body .border-secondary { border-color: #F39C12 !important; }

.btn-primary {
    background: linear-gradient(135deg, #2C3E50, #34495e) !important;
    color: white !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #1a252f, #2C3E50) !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 15px 35px rgba(44, 62, 80, 0.4) !important;
}
.btn-primary::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: -100% !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent) !important;
    transition: left 0.5s !important;
}
.btn-primary:hover::before {
    left: 100% !important;
}

.btn-secondary {
    background: linear-gradient(135deg, #F39C12, #f4a62a) !important;
    color: white !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
}
.btn-secondary:hover {
    background: linear-gradient(135deg, #d68910, #F39C12) !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 15px 35px rgba(243, 156, 18, 0.4) !important;
}
.btn-secondary::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: -100% !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent) !important;
    transition: left 0.5s !important;
}
.btn-secondary:hover::before {
    left: 100% !important;
}

@keyframes fadeInUp {
    0% { 
        opacity: 0 !important; 
        transform: translateY(60px) !important; 
    }
    100% { 
        opacity: 1 !important; 
        transform: translateY(0) !important; 
    }
}

@keyframes fadeInDown {
    0% { 
        opacity: 0 !important; 
        transform: translateY(-40px) !important; 
    }
    100% { 
        opacity: 1 !important; 
        transform: translateY(0) !important; 
    }
}

.animate-fade-in-up { 
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; 
    animation-fill-mode: forwards !important;
}
.animate-fade-in-down { 
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; 
    animation-fill-mode: forwards !important;
}

.animation-delay-200 { animation-delay: 0.2s !important; }
.animation-delay-400 { animation-delay: 0.4s !important; }
.animation-delay-600 { animation-delay: 0.6s !important; }
.animation-delay-800 { animation-delay: 0.8s !important; }
.animation-delay-1000 { animation-delay: 1s !important; }

.product-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: 2px solid transparent !important;
    position: relative !important;
    overflow: hidden !important;
}
.product-card:hover {
    transform: translateY(-12px) scale(1.03) !important;
    border-color: #F39C12 !important;
    box-shadow: 0 25px 50px rgba(44, 62, 80, 0.15) !important;
}
.product-card::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 4px !important;
    background: linear-gradient(90deg, #F39C12, #f4a62a) !important;
    transform: translateX(-100%) !important;
    transition: transform 0.4s ease !important;
}
.product-card:hover::before {
    transform: translateX(0) !important;
}

.category-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    background: linear-gradient(135deg, white 0%, #f8fafc 100%) !important;
    position: relative !important;
    overflow: hidden !important;
}
.category-card:hover {
    transform: translateY(-8px) scale(1.02) !important;
    box-shadow: 0 20px 40px rgba(44, 62, 80, 0.1) !important;
    background: linear-gradient(135deg, #F39C12 0%, #f4a62a 100%) !important;
    color: white !important;
}

.scroll-indicator {
    position: absolute !important;
    bottom: 40px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    animation: float 3s ease-in-out infinite !important;
    cursor: pointer !important;
}

.hero-text-gradient {
    background: linear-gradient(135deg, #F39C12 0%, #f4a62a 50%, #F39C12 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
    animation: shimmer 3s ease-in-out infinite !important;
    background-size: 200px 100% !important;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.stat-card {
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}
.stat-card:hover {
    transform: scale(1.1) !important;
}

/* Override any conflicting Tailwind classes */
.hero-bg * {
    --tw-bg-opacity: 1 !important;
}

/* Force our color scheme */
section.hero-bg {
    background: linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%) !important;
}
</style>

    <!-- Hero Section -->
    <section class="relative pt-16 text-white overflow-hidden min-h-screen flex items-center" style="background: linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%) !important;">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-96 h-96 rounded-full mix-blend-multiply filter blur-3xl opacity-20" style="background: linear-gradient(to right, #3b82f6, #1e40af);"></div>
            <div class="absolute top-40 right-10 w-80 h-80 rounded-full mix-blend-multiply filter blur-3xl opacity-25" style="background: linear-gradient(to right, #F39C12, #d97706);"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 rounded-full mix-blend-multiply filter blur-3xl opacity-20" style="background: linear-gradient(to right, #2C3E50, #F39C12);"></div>
        </div>

        <div class="container mx-auto flex flex-col items-center justify-between px-4 py-16 relative z-10">
            <!-- Main Content -->
            <div class="w-full text-center relative">
                <!-- Badge -->
                <div class="glass-effect text-white px-8 py-4 rounded-full text-sm font-semibold mb-8 inline-flex items-center shadow-2xl">
                    <i class="fas fa-trophy mr-3" style="color: #F39C12;"></i>
                    #1 Trusted Fitness Supplements Store
                    <span class="ml-3 px-3 py-1 rounded-full text-xs font-bold" style="background-color: #F39C12; color: white;">PREMIUM</span>
                </div>
                    <span class="mr-2">�</span>
                    #1 Trusted Fitness Supplements Store
                    <span class="ml-2 bg-orange-500 text-white px-2 py-1 rounded-full text-xs">PREMIUM</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-6xl md:text-7xl font-black mb-8 leading-tight">
                    <span class="hero-text-gradient">
                        Build Your Best
                    </span>
                    <br>
                    <span class="text-white">Physique</span>
                </h1>

                <!-- Subtitle -->
                <p class="mb-12 text-2xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
                    Discover premium protein powders, pre-workouts, and cutting-edge supplements designed by fitness experts to maximize your gains and athletic performance.
                </p>

                <!-- Stats Row -->
                <div class="flex flex-wrap justify-center gap-8 mb-12">
                    <div class="text-center stat-card">
                        <div class="text-4xl font-bold" style="color: #F39C12;">{{$totalUsers ?? '15'}}K+</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-users mr-1"></i>Fitness Enthusiasts</div>
                    </div>
                    <div class="text-center stat-card">
                        <div class="text-4xl font-bold" style="color: #F39C12;">{{$totalProducts ?? '2500'}}+</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-capsules mr-1"></i>Premium Supplements</div>
                    </div>
                    <div class="text-center stat-card">
                        <div class="text-4xl font-bold" style="color: #F39C12;">24/7</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-headset mr-1"></i>Nutrition Support</div>
                    </div>
                    <div class="text-center stat-card">
                        <div class="text-4xl font-bold" style="color: #F39C12;">98%</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-heart mr-1"></i>Customer Satisfaction</div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{route('user.shop')}}" class="px-12 py-5 rounded-full font-bold text-lg group transition-all duration-300" style="background: linear-gradient(135deg, #2C3E50, #34495e); color: white;">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-shopping-cart mr-3"></i>Shop Supplements
                            <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </span>
                    </a>
                    
                    <a href="#categories" class="px-12 py-5 rounded-full font-bold text-lg group transition-all duration-300" style="background: linear-gradient(135deg, #F39C12, #f4a62a); color: white;">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-th-large mr-3"></i>Browse Categories
                            <i class="fas fa-arrow-down ml-3 group-hover:translate-y-2 transition-transform duration-300"></i>
                        </span>
                    </a>
                </div>

                <div class="absolute bottom-40 left-1/2 transform -translate-x-1/2 cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-sm text-gray-300 mb-2">Scroll to explore</span>
                        <i class="fas fa-chevron-down text-2xl" style="color: #F39C12;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap justify-center items-center gap-8 mt-16 opacity-70">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        100% Genuine Products
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Free Shipping Over Rs 5000
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        1-Year Warranty
                    </div>
                </div>
            </div>
            
            <!-- Featured Products Showcase -->
            <div class="flex flex-col md:flex-row items-center justify-center mt-16 space-y-6 md:space-y-0 md:space-x-8 relative z-10">
                @if($featuredproducts && $featuredproducts->count() > 0)
                    @foreach($featuredproducts->take(2) as $index => $product)
                    <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="relative overflow-hidden rounded-xl mb-4">
                            <img src="{{asset('images/product/'.$product->image)}}" alt="{{$product->name}}" class="w-40 h-40 object-cover mx-auto group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-2 right-2 bg-{{$index == 0 ? 'red' : 'emerald'}}-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                {{$index == 0 ? 'POPULAR' : 'FEATURED'}}
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-center text-gray-800 mb-2">{{$product->name}}</h3>
                        <div class="text-center">
                            <span class="text-2xl font-bold text-orange-600">Rs {{number_format($product->price)}}</span>
                            <span class="text-sm text-gray-500 line-through ml-2">Rs {{number_format($product->price + 500)}}</span>
                        </div>
                        <div class="flex items-center justify-center mt-2 mb-4">
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                            <span class="text-sm text-gray-500 ml-2">({{rand(25, 150)}} reviews)</span>
                        </div>
                        <a href="{{route('user.productdetails', $product->id)}}" class="block w-full text-center bg-gradient-to-r from-orange-500 to-red-600 text-white py-3 px-4 rounded-xl hover:from-orange-600 hover:to-red-700 transition-all duration-300 font-semibold transform hover:scale-105">
                            🛒 Add to Cart
                        </a>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback featured products -->
                    <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="relative overflow-hidden rounded-xl mb-4">
                            <img src="{{asset('images/product/protein.jpg')}}" alt="Whey Protein" class="w-40 h-40 object-cover mx-auto group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                POPULAR
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-center text-gray-800 mb-2">Whey Protein - 5lbs</h3>
                        <div class="text-center">
                            <span class="text-2xl font-bold text-orange-600">Rs 4,500</span>
                            <span class="text-sm text-gray-500 line-through ml-2">Rs 5,000</span>
                        </div>
                        <div class="flex items-center justify-center mt-2 mb-4">
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(87 reviews)</span>
                        </div>
                        <a href="#" class="block w-full text-center bg-gradient-to-r from-orange-500 to-red-600 text-white py-3 px-4 rounded-xl hover:from-orange-600 hover:to-red-700 transition-all duration-300 font-semibold transform hover:scale-105">
                            🛒 Add to Cart
                        </a>
                    </div>
                    
                    <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="relative overflow-hidden rounded-xl mb-4">
                            <img src="{{asset('images/product/preworkout.jpg')}}" alt="Pre-Workout" class="w-40 h-40 object-cover mx-auto group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-2 right-2 bg-emerald-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                FEATURED
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-center text-gray-800 mb-2">Pre-Workout Booster</h3>
                        <div class="text-center">
                            <span class="text-2xl font-bold text-orange-600">Rs 2,500</span>
                            <span class="text-sm text-gray-500 line-through ml-2">Rs 2,800</span>
                        </div>
                        <div class="flex items-center justify-center mt-2 mb-4">
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(63 reviews)</span>
                        </div>
                        <a href="#" class="block w-full text-center bg-gradient-to-r from-orange-500 to-red-600 text-white py-3 px-4 rounded-xl hover:from-orange-600 hover:to-red-700 transition-all duration-300 font-semibold transform hover:scale-105">
                            🛒 Add to Cart
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-white py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Why Choose KisanTools?</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-red-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're committed to providing the highest quality fitness supplements backed by science and trusted by athletes and fitness enthusiasts across the country.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Premium Quality</h3>
                    <p class="text-gray-600">Every tool is rigorously tested for durability, efficiency, and performance to ensure maximum productivity in your fields.</p>
                </div>
                
                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Expert Approved</h3>
                    <p class="text-gray-600">Recommended by agricultural experts and used by successful farmers to optimize crop yields and farming efficiency.</p>
                </div>
                
                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 hover:from-amber-100 hover:to-amber-200 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Fast Delivery</h3>
                    <p class="text-gray-600">Quick nationwide delivery with special handling for delicate equipment. Express shipping available for urgent farming needs.</p>
                </div>
                
                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-1.106-1.106A6.003 6.003 0 004 10c0 .639.099 1.255.283 1.836l1.375-1.375zm3.477-4.676l-1.624-1.624A5.97 5.97 0 0110 4c.824 0 1.601.156 2.317.436l-1.388 1.388a5.99 5.99 0 00-1.694.027z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">24/7 Support</h3>
                    <p class="text-gray-600">Our agricultural experts are available around the clock to help you choose the right tools and provide technical assistance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Products Section -->
    <section id="categories" class="bg-white py-20">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Tool Categories</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Discover our comprehensive range of agricultural tools and equipment designed to enhance your farming productivity and efficiency.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                @foreach($categories as $category)
                <div class="group bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden group-hover:scale-110 transition-transform duration-300">
                            @if(str_contains(strtolower($category->name), 'protein'))
                                <img src="{{asset('images/product/protein.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @elseif(str_contains(strtolower($category->name), 'pre-workout') || str_contains(strtolower($category->name), 'preworkout'))
                                <img src="{{asset('images/product/preworkout.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @elseif(str_contains(strtolower($category->name), 'creatine'))
                                <img src="{{asset('images/product/creatine.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @elseif(str_contains(strtolower($category->name), 'bcaa') || str_contains(strtolower($category->name), 'amino'))
                                <img src="{{asset('images/product/bcaa.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @elseif(str_contains(strtolower($category->name), 'mass') || str_contains(strtolower($category->name), 'gainer'))
                                <img src="{{asset('images/product/mass_gainer.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @else
                                <img src="{{asset('images/product/supplement.jpg')}}" alt="{{$category->name}}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                            {{$category->products->count()}}
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{$category->name}}</h3>
                    <p class="text-gray-600 mb-2">{{$category->description ?? 'Premium fitness supplements'}}</p>
                    <p class="text-sm text-blue-600 font-semibold mb-6">{{$category->products->count()}} Products Available</p>
                    <a href="{{route('user.categorysearch', $category->id)}}" class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-full hover:from-blue-600 hover:to-purple-700 transition-all duration-300 font-semibold group-hover:scale-105">
                        @if(str_contains(strtolower($category->name), 'protein'))
                            Explore More �
                        @elseif(str_contains(strtolower($category->name), 'pre-workout'))
                            Explore More ⚡
                        @elseif(str_contains(strtolower($category->name), 'creatine'))
                            Explore More 🔥
                        @elseif(str_contains(strtolower($category->name), 'mass'))
                            Explore More 📈
                        @else
                            Explore More 🏋️
                        @endif
                    </a>
                </div>
                @endforeach
                
                @if($categories->count() == 0)
                <!-- Fallback categories if no categories exist -->
                <div class="group bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden group-hover:scale-110 transition-transform duration-300">
                            <img src="{{asset('images/product/protein.jpg')}}" alt="Protein Powders" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -top-2 -right-2 bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                            25
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Protein Powders</h3>
                    <p class="text-gray-600 mb-2">Premium muscle building supplements</p>
                    <p class="text-sm text-blue-600 font-semibold mb-6">25 Products Available</p>
                    <a href="#" class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 px-6 rounded-full hover:from-orange-600 hover:to-orange-700 transition-all duration-300 font-semibold group-hover:scale-105">
                        Explore More �
                    </a>
                </div>
                
                <div class="group bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden group-hover:scale-110 transition-transform duration-300">
                            <img src="{{asset('images/product/preworkout.jpg')}}" alt="Pre-Workout" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -top-2 -right-2 bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                            18
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Pre-Workout</h3>
                    <p class="text-gray-600 mb-2">Energy & focus enhancement</p>
                    <p class="text-sm text-blue-600 font-semibold mb-6">18 Products Available</p>
                    <a href="#" class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-semibold group-hover:scale-105">
                        Explore More ⚡
                    </a>
                </div>
                
                <div class="group bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden group-hover:scale-110 transition-transform duration-300">
                            <img src="{{asset('images/product/creatine.jpg')}}" alt="Creatine" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -top-2 -right-2 bg-emerald-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                            12
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Creatine</h3>
                    <p class="text-gray-600 mb-2">Strength & power enhancement</p>
                    <p class="text-sm text-blue-600 font-semibold mb-6">12 Products Available</p>
                    <a href="#" class="inline-flex items-center justify-center bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-3 px-6 rounded-full hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 font-semibold group-hover:scale-105">
                        Explore More 🔥
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Best Selling Products Section -->
    <section class="bg-gradient-to-br from-emerald-50 to-green-50 py-20">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Best Selling Tools</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-green-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Our most popular agricultural tools trusted by thousands of farmers nationwide for their reliability and performance.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
                @if($bestsellingproducts && $bestsellingproducts->count() > 0)
                    @foreach($bestsellingproducts as $index => $product)
                    <div class="group bg-white shadow-lg rounded-2xl overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                        <div class="relative overflow-hidden">
                            <img src="{{asset('images/product/'.$product->image)}}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                #{{$index + 1}} BESTSELLER
                            </div>
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button class="bg-white text-red-500 w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors duration-300">
                                    ❤️
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors duration-300">{{$product->name}}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{Str::limit($product->description, 60)}}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-emerald-600">Rs {{number_format($product->price)}}</span>
                                <div class="flex text-yellow-400 text-sm">
                                    ⭐⭐⭐⭐⭐
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-500">Stock: {{$product->stock}}</span>
                                <span class="text-sm text-green-600 font-semibold">{{rand(50, 300)}} sold</span>
                            </div>
                            <a href="{{route('user.productdetails', $product->id)}}" class="block w-full bg-gradient-to-r from-emerald-500 to-green-600 text-white text-center py-3 px-4 rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all duration-300 font-semibold transform group-hover:scale-105">
                                🛒 Add to Cart
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback if no products -->
                    <div class="col-span-full text-center py-10">
                        <h3 class="text-xl text-gray-600">No best selling tools available at the moment.</h3>
                        <a href="{{route('user.shop')}}" class="inline-block mt-4 bg-emerald-500 text-white px-6 py-3 rounded-lg hover:bg-emerald-600 transition-colors">
                            Browse All Tools
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Weekly Sale Section -->
    <section class="bg-gradient-to-r from-green-500 via-emerald-600 to-green-700 py-20 text-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-48 h-48 bg-white opacity-5 rounded-full"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white opacity-10 rounded-full animate-pulse"></div>
        </div>
        
        <div class="container mx-auto text-center relative z-10">
            <div class="bg-white bg-opacity-20 rounded-2xl p-2 inline-block mb-6">
                <div class="flex justify-center items-center space-x-6 text-lg md:text-xl font-bold" id="countdown">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-black" id="days">5</div>
                        <div class="text-sm opacity-90">Days</div>
                    </div>
                    <div class="text-2xl">:</div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-black" id="hours">14</div>
                        <div class="text-sm opacity-90">Hours</div>
                    </div>
                    <div class="text-2xl">:</div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-black" id="minutes">32</div>
                        <div class="text-sm opacity-90">Minutes</div>
                    </div>
                    <div class="text-2xl">:</div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-black" id="seconds">18</div>
                        <div class="text-sm opacity-90">Seconds</div>
                    </div>
                </div>
            </div>
            
            <h2 class="text-4xl md:text-5xl font-bold mb-4">🔥 Season End Sale</h2>
            <p class="text-xl mb-8 opacity-90">Buy any Tractor & get FREE Fertilizer Spreader worth Rs 15,000!</p>
            
            <div class="flex flex-col md:flex-row justify-center items-center space-y-6 md:space-y-0 md:space-x-8 mb-8">
                <div class="bg-white bg-opacity-20 p-6 rounded-2xl backdrop-blur-sm">
                    <img src="{{asset('images/product/tractor_sale.jpg')}}" alt="Tractor" class="w-40 h-40 object-cover rounded-xl mx-auto mb-4">
                    <div class="text-center">
                        <h4 class="font-bold text-lg">Any Tractor</h4>
                        <p class="text-sm opacity-90">Premium Quality</p>
                    </div>
                </div>
                
                <div class="text-4xl animate-bounce">+</div>
                
                <div class="bg-white bg-opacity-20 p-6 rounded-2xl backdrop-blur-sm">
                    <img src="{{asset('images/product/spreader.jpg')}}" alt="Fertilizer Spreader" class="w-40 h-40 object-cover rounded-xl mx-auto mb-4">
                    <div class="text-center">
                        <h4 class="font-bold text-lg">Fertilizer Spreader</h4>
                        <p class="text-sm opacity-90">FREE Gift!</p>
                    </div>
                </div>
            </div>
            
            <a href="{{route('user.shop')}}" class="inline-flex items-center bg-white text-green-600 px-8 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 font-bold text-lg transform hover:scale-105 shadow-lg">
                🚜 Claim This Deal Now!
            </a>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="bg-gradient-to-br from-gray-50 to-white py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">What Our Farmers Say</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Join thousands of satisfied farmers who have enhanced their agricultural productivity with our premium tools and equipment.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <img src="{{asset('images/testimonial1.jpg')}}" alt="Customer" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Rajesh Kumar</h4>
                            <p class="text-sm text-gray-600">Progressive Farmer</p>
                            <div class="flex text-yellow-400 text-sm mt-1">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Outstanding quality tractors! My productivity increased by 40% after purchasing from KisanTools. The after-sales service is excellent and delivery was right on time."</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <img src="{{asset('images/testimonial2.jpg')}}" alt="Customer" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Priya Sharma</h4>
                            <p class="text-sm text-gray-600">Organic Farmer</p>
                            <div class="flex text-yellow-400 text-sm mt-1">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Best agricultural tools store I've ever used! The irrigation systems are amazing and the customer support team is very knowledgeable. Highly recommend to all farmers."</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <img src="{{asset('images/testimonial3.jpg')}}" alt="Customer" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Sunil Patel</h4>
                            <p class="text-sm text-gray-600">Commercial Farmer</p>
                            <div class="flex text-yellow-400 text-sm mt-1">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"I recommend KisanTools to all fellow farmers. Premium quality equipment at competitive prices. The seeders I bought have revolutionized my planting process."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Latest Agricultural Tools</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Discover our newest arrivals and trending agricultural equipment for modern farming
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4">
                @foreach($latestproducts as $product)
                <div class="group bg-white shadow-lg rounded-2xl overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="{{asset('images/product/'.$product->image)}}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            NEW
                        </div>
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white text-red-500 w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors duration-300">
                                ❤️
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors duration-300">{{$product->name}}</h3>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-emerald-600">Rs {{number_format($product->price)}}</span>
                            <div class="flex text-yellow-400 text-sm">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                        <a href="{{route('user.productdetails', $product->id)}}" class="block w-full bg-gradient-to-r from-gray-800 to-gray-900 text-white text-center py-3 px-4 rounded-xl hover:from-emerald-500 hover:to-emerald-600 transition-all duration-300 font-semibold transform group-hover:scale-105">
                            🛒 Buy Now
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trusted Brands Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900">Trusted Agricultural Brands</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    We partner with the world's most respected agricultural equipment manufacturers to bring you authentic, high-quality farming tools.
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center opacity-60 hover:opacity-100 transition-opacity duration-300">
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">MAHINDRA</div>
                        <div class="text-xs text-gray-500">TRACTORS</div>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">JOHN DEERE</div>
                        <div class="text-xs text-gray-500">EQUIPMENT</div>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">TAFE</div>
                        <div class="text-xs text-gray-500">MASSEY FERGUSON</div>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">KUBOTA</div>
                        <div class="text-xs text-gray-500">PREMIUM TOOLS</div>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">NEW HOLLAND</div>
                        <div class="text-xs text-gray-500">AGRICULTURE</div>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-700">SONALIKA</div>
                        <div class="text-xs text-gray-500">INTERNATIONAL</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="bg-gradient-to-br from-green-50 to-emerald-50 py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Our Services</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Beyond selling tools, we provide comprehensive agricultural support services to help you succeed.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl text-white">🚚</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Free Delivery</h3>
                    <p class="text-gray-600">Fast and secure delivery across India. Free shipping on orders above Rs 5,000.</p>
                </div>
                
                <div class="group text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl text-white">🔧</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Installation Support</h3>
                    <p class="text-gray-600">Professional installation and setup services for complex agricultural equipment.</p>
                </div>
                
                <div class="group text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl text-white">📞</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Expert Consultation</h3>
                    <p class="text-gray-600">Get personalized advice from our agricultural experts to choose the right tools.</p>
                </div>
                
                <div class="group text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl text-white">⚙️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Maintenance Service</h3>
                    <p class="text-gray-600">Regular maintenance and repair services to keep your equipment running smoothly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-gradient-to-r from-gray-900 to-gray-800 py-20 text-white">
        <div class="container mx-auto text-center px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Stay Connected with KisanTools!</h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Subscribe to our newsletter and get exclusive deals, farming tips, seasonal guides, and new product announcements.
                </p>
                <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4 max-w-md mx-auto mb-8">
                    <input type="email" placeholder="Enter your email" class="w-full px-6 py-4 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-green-500">
                    <button class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-full hover:from-green-600 hover:to-emerald-700 transition-all duration-300 font-semibold whitespace-nowrap">
                        Subscribe 📧
                    </button>
                </div>
                
                <!-- Additional Benefits -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                    <div class="flex items-center justify-center space-x-3 bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                        <div class="text-green-400 text-2xl">💰</div>
                        <div class="text-left">
                            <h4 class="font-semibold">Exclusive Discounts</h4>
                            <p class="text-sm text-gray-300">Up to 25% off</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-3 bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                        <div class="text-emerald-400 text-2xl">🌾</div>
                        <div class="text-left">
                            <h4 class="font-semibold">Farming Guides</h4>
                            <p class="text-sm text-gray-300">Expert tips</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-3 bg-gray-800 bg-opacity-50 p-4 rounded-lg">
                        <div class="text-amber-400 text-2xl">🎁</div>
                        <div class="text-left">
                            <h4 class="font-semibold">Early Access</h4>
                            <p class="text-sm text-gray-300">New tools</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA Section -->
    <section class="bg-gradient-to-r from-green-600 to-emerald-600 py-16 text-white">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Boost Your Farm Productivity?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of successful farmers who trust KisanTools for their agricultural needs</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{route('user.shop')}}" class="bg-white text-green-600 px-8 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 font-bold text-lg transform hover:scale-105 shadow-lg">
                    🛒 Start Shopping Now
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-full hover:bg-white hover:text-green-600 transition-all duration-300 font-bold text-lg">
                    📞 Contact Expert
                </a>
            </div>
        </div>
    </section>

</body>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}

.animate-fade-in-down {
    animation: fade-in-down 0.6s ease-out;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-900 {
    animation-delay: 0.9s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes pulse {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 0.3; }
}

.animate-pulse {
    animation: pulse 3s infinite;
}

/* Responsive Design */
@media (max-width: 768px) {
    .text-4xl { font-size: 2.5rem; }
    .text-5xl { font-size: 3rem; }
    .text-6xl { font-size: 3.5rem; }
    .text-7xl { font-size: 4rem; }
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #10b981, #059669);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #059669, #047857);
}

/* Loading animation for images */
img {
    transition: all 0.3s ease;
}

img:hover {
    filter: brightness(1.1);
}

/* Custom button hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

/* Border animation */
.border-3 {
    border-width: 3px;
}

/* Enhanced gradient animations */
.bg-gradient-to-r {
    background-size: 300% 300%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Enhanced card shadows */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Smooth transitions for all interactive elements */
* {
    transition: all 0.3s ease;
}

/* Custom agricultural themed colors */
.text-kisan-green {
    color: #16a34a;
}

.bg-kisan-green {
    background-color: #16a34a;
}

.text-kisan-amber {
    color: #d97706;
}

.bg-kisan-amber {
    background-color: #d97706;
}

/* Enhanced mobile responsiveness */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        gap: 1rem;
    }
    
    .text-2xl {
        font-size: 1.5rem;
    }
    
    .py-20 {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Focus states for accessibility */
button:focus,
a:focus,
input:focus {
    outline: 2px solid #10b981;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .no-print {
        display: none;
    }
}

/* Enhanced button effects */
button, a {
    position: relative;
    overflow: hidden;
}

button::before, a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

button:hover::before, a:hover::before {
    left: 100%;
}
</style>

<script>
// Countdown Timer
function startCountdown() {
    // Set the date we're counting down to (7 days from now)
    const countDownDate = new Date().getTime() + (7 * 24 * 60 * 60 * 1000);

    // Update the countdown every 1 second
    const timer = setInterval(function() {
        // Get current date and time
        const now = new Date().getTime();
        
        // Find the distance between now and the countdown date
        const distance = countDownDate - now;
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Display the result
        document.getElementById("days").innerHTML = days;
        document.getElementById("hours").innerHTML = hours;
        document.getElementById("minutes").innerHTML = minutes;
        document.getElementById("seconds").innerHTML = seconds;
        
        // If the countdown is finished, restart it
        if (distance < 0) {
            clearInterval(timer);
            startCountdown(); // Restart the countdown
        }
    }, 1000);
}

// Start countdown when page loads
document.addEventListener('DOMContentLoaded', function() {
    startCountdown();
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading animation for images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.style.opacity = '0.5';
            this.alt = 'Image not available';
        });
        
        // Set initial opacity
        img.style.opacity = '0.8';
        img.style.transition = 'opacity 0.3s ease';
    });
});

// Newsletter subscription
function subscribeNewsletter() {
    const email = document.querySelector('input[type="email"]').value;
    if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        // Here you would typically send the email to your backend
        alert('Thank you for subscribing to KisanTools newsletter!');
        document.querySelector('input[type="email"]').value = '';
    } else {
        alert('Please enter a valid email address.');
    }
}

// Add click event to subscribe button
document.addEventListener('DOMContentLoaded', function() {
    const subscribeBtn = document.querySelector('button:not([type]), button:contains("Subscribe")');
    if (subscribeBtn) {
        subscribeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            subscribeNewsletter();
        });
    }
});

// Add scroll animation
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.bg-gradient-to-br');
    if (parallax) {
        const speed = scrolled * 0.5;
        parallax.style.transform = `translateY(${speed}px)`;
    }
});

// Add intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});

// Force apply our color scheme after page load
window.addEventListener('load', function() {
    setTimeout(function() {
        // Force hero background
        const heroSection = document.querySelector('.hero-bg');
        if (heroSection) {
            heroSection.style.background = 'linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%)';
            heroSection.style.setProperty('background', 'linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%)', 'important');
        }
        
        // Force primary buttons
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.background = 'linear-gradient(135deg, #2C3E50, #34495e)';
            btn.style.setProperty('background', 'linear-gradient(135deg, #2C3E50, #34495e)', 'important');
            btn.style.color = 'white';
            btn.style.setProperty('color', 'white', 'important');
        });
        
        // Force secondary buttons
        document.querySelectorAll('.btn-secondary').forEach(btn => {
            btn.style.background = 'linear-gradient(135deg, #F39C12, #f4a62a)';
            btn.style.setProperty('background', 'linear-gradient(135deg, #F39C12, #f4a62a)', 'important');
            btn.style.color = 'white';
            btn.style.setProperty('color', 'white', 'important');
        });
        
        // Force text colors
        document.querySelectorAll('.text-secondary').forEach(el => {
            el.style.color = '#F39C12';
            el.style.setProperty('color', '#F39C12', 'important');
        });
        
        document.querySelectorAll('.text-primary').forEach(el => {
            el.style.color = '#2C3E50';
            el.style.setProperty('color', '#2C3E50', 'important');
        });
        
        // Force background colors
        document.querySelectorAll('.bg-primary').forEach(el => {
            el.style.backgroundColor = '#2C3E50';
            el.style.setProperty('background-color', '#2C3E50', 'important');
        });
        
        document.querySelectorAll('.bg-secondary').forEach(el => {
            el.style.backgroundColor = '#F39C12';
            el.style.setProperty('background-color', '#F39C12', 'important');
        });
        
        console.log('Color scheme forcefully applied!');
    }, 100);
});

// Also apply on DOM content loaded
document.addEventListener('DOMContentLoaded', function() {
    // Apply colors immediately
    const style = document.createElement('style');
    style.innerHTML = `
        :root {
            --primary-color: #2C3E50 !important;
            --secondary-color: #F39C12 !important;
        }
        .hero-bg {
            background: linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%) !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2C3E50, #34495e) !important;
            color: white !important;
        }
        .btn-secondary {
            background: linear-gradient(135deg, #F39C12, #f4a62a) !important;
            color: white !important;
        }
        .text-secondary {
            color: #F39C12 !important;
        }
        .bg-primary {
            background-color: #2C3E50 !important;
        }
    `;
    document.head.appendChild(style);
});
</script>

@endsection