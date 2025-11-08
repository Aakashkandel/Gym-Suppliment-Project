@extends('layouts.usermenu')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body class="bg-gray-50 text-gray-900">

<style>
.hero-bg {
    background: linear-gradient(135deg, #2C3E50 0%, #34495e 50%, #2C3E50 100%) !important;
}

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

.glass-effect {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}
</style>

    <!-- Hero Section -->
    <section class="relative pt-16 text-white overflow-hidden min-h-screen flex items-center hero-bg">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-96 h-96 rounded-full mix-blend-multiply filter blur-3xl opacity-20 bg-blue-300"></div>
            <div class="absolute top-40 right-10 w-80 h-80 rounded-full mix-blend-multiply filter blur-3xl opacity-25" style="background: #F39C12;"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 rounded-full mix-blend-multiply filter blur-3xl opacity-20" style="background: #2C3E50;"></div>
        </div>

        <div class="container mx-auto flex flex-col items-center justify-center px-4 py-16 relative z-10">
            <div class="w-full text-center">
                <!-- Badge -->
                <div class="glass-effect text-white px-8 py-4 rounded-full text-sm font-semibold mb-8 inline-flex items-center shadow-2xl">
                    <i class="fas fa-dumbbell mr-3" style="color: #F39C12;"></i>
                    #1 Trusted Fitness Supplements Store
                    <span class="ml-3 px-3 py-1 rounded-full text-xs font-bold" style="background-color: #F39C12; color: white;">PREMIUM</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-6xl md:text-7xl font-black mb-8 leading-tight">
                    <span style="background: linear-gradient(135deg, #F39C12 0%, #f4a62a 50%, #F39C12 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
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
                    <div class="text-center">
                        <div class="text-4xl font-bold" style="color: #F39C12;">{{$totalUsers ?? '15'}}K+</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-users mr-1"></i>Fitness Enthusiasts</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold" style="color: #F39C12;">{{$totalProducts ?? count($latestproducts)}}+</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-capsules mr-1"></i>Premium Supplements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold" style="color: #F39C12;">24/7</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-headset mr-1"></i>Nutrition Support</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold" style="color: #F39C12;">98%</div>
                        <div class="text-sm text-gray-300"><i class="fas fa-heart mr-1"></i>Customer Satisfaction</div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{route('user.shop')}}" class="px-12 py-5 rounded-full font-bold text-lg btn-primary group">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-shopping-cart mr-3"></i>Shop Supplements
                            <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                        </span>
                    </a>
                    
                    <a href="#categories" class="px-12 py-5 rounded-full font-bold text-lg btn-secondary group">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-th-large mr-3"></i>Browse Categories
                            <i class="fas fa-arrow-down ml-3 group-hover:translate-y-2 transition-transform duration-300"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="bg-white py-20">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Supplement Categories</h2>
                <div class="w-24 h-1 mx-auto mb-6" style="background: linear-gradient(to right, #F39C12, #f4a62a);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Discover our comprehensive range of fitness supplements designed to enhance your workout performance and recovery.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                @foreach($categories as $category)
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border border-gray-100 category-card">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 mx-auto rounded-2xl flex items-center justify-center group-hover:bg-white transition-colors duration-300" style="background-color: #f0f0f0;">
                            @if(str_contains(strtolower($category->name), 'protein'))
                                <i class="fas fa-dumbbell text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @elseif(str_contains(strtolower($category->name), 'pre-workout') || str_contains(strtolower($category->name), 'preworkout'))
                                <i class="fas fa-bolt text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @elseif(str_contains(strtolower($category->name), 'creatine'))
                                <i class="fas fa-fire text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @elseif(str_contains(strtolower($category->name), 'bcaa') || str_contains(strtolower($category->name), 'amino'))
                                <i class="fas fa-molecule text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @elseif(str_contains(strtolower($category->name), 'mass') || str_contains(strtolower($category->name), 'gainer'))
                                <i class="fas fa-chart-line text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @else
                                <i class="fas fa-capsules text-3xl group-hover:text-white" style="color: #F39C12;"></i>
                            @endif
                        </div>
                        <div class="absolute -top-2 -right-2 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold" style="background-color: #F39C12;">
                            {{$category->products->count()}}
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-white">{{$category->name}}</h3>
                    <p class="text-gray-600 group-hover:text-gray-200 mb-2">{{$category->description ?? 'Premium fitness supplements'}}</p>
                    <p class="text-sm font-semibold mb-6 group-hover:text-white" style="color: #F39C12;">{{$category->products->count()}} Products Available</p>
                    <a href="{{route('user.categorysearch', $category->id)}}" class="inline-flex items-center justify-center text-white py-3 px-6 rounded-full transition-all duration-300 font-semibold group-hover:bg-white" style="background-color: #F39C12;" onmouseover="this.style.color='#F39C12';" onmouseout="this.style.color='white';">
                        Explore More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Best Selling Products Section -->
    @if($bestsellingproducts && $bestsellingproducts->count() > 0)
    <section class="py-20" style="background: linear-gradient(to bottom right, #f8f9fa, #e9ecef);">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Best Selling Supplements</h2>
                <div class="w-24 h-1 mx-auto mb-6" style="background: linear-gradient(to right, #F39C12, #f4a62a);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Our most popular fitness supplements trusted by thousands of athletes and fitness enthusiasts.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
                @foreach($bestsellingproducts as $index => $product)
                <div class="group bg-white shadow-lg rounded-2xl overflow-hidden product-card">
                    <div class="relative overflow-hidden">

                        <img src="{{asset('images/'.$product->image)}}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4 text-white px-3 py-1 rounded-full text-xs font-bold" style="background: linear-gradient(to right, #F39C12, #f4a62a);">
                            #{{$index + 1}} BESTSELLER
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors duration-300">{{$product->name}}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{Str::limit($product->description, 60)}}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold" style="color: #F39C12;">Rs {{number_format($product->price)}}</span>
                            <div class="flex text-yellow-400 text-sm">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Stock: {{$product->stock}}</span>
                            <span class="text-sm font-semibold" style="color: #F39C12;">{{rand(50, 300)}} sold</span>
                        </div>
                        <a href="{{route('user.productdetails', $product->id)}}" class="block w-full text-white text-center py-3 px-4 rounded-xl hover:opacity-90 transition-all duration-300 font-semibold" style="background: linear-gradient(to right, #2C3E50, #34495e);">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Products Section -->
    @if($latestproducts && $latestproducts->count() > 0)
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Latest Arrivals</h2>
                <div class="w-24 h-1 mx-auto mb-6" style="background: linear-gradient(to right, #2C3E50, #34495e);"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Discover our newest fitness supplements and trending products
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4">
                @foreach($latestproducts as $product)
                <div class="group bg-white shadow-lg rounded-2xl overflow-hidden product-card">
                    <div class="relative overflow-hidden">
                        <img src="{{asset('images/'.$product->image)}}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-4 left-4 text-white px-3 py-1 rounded-full text-xs font-bold" style="background-color: #2C3E50;">
                            NEW
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors duration-300">{{$product->name}}</h3>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold" style="color: #F39C12;">Rs {{number_format($product->price)}}</span>
                            <div class="flex text-yellow-400 text-sm">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                        <a href="{{route('user.productdetails', $product->id)}}" class="block w-full text-white text-center py-3 px-4 rounded-xl hover:opacity-90 transition-all duration-300 font-semibold" style="background: linear-gradient(to right, #F39C12, #f4a62a);">
                            <i class="fas fa-shopping-cart mr-2"></i>Buy Now
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Footer CTA Section -->
    <section class="py-16 text-white" style="background: linear-gradient(to right, #2C3E50, #34495e);">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Transform Your Fitness Journey?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of fitness enthusiasts who trust Aakash Gym Supplements for their nutritional needs</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{route('user.shop')}}" class="bg-white px-8 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 font-bold text-lg transform hover:scale-105 shadow-lg" style="color: #2C3E50;">
                    <i class="fas fa-shopping-cart mr-2"></i>Start Shopping Now
                </a>
                <a href="{{route('user.aboutus')}}" class="border-2 border-white text-white px-8 py-4 rounded-full hover:bg-white transition-all duration-300 font-bold text-lg" style="hover:color: #2C3E50;" onmouseover="this.style.color='#2C3E50';" onmouseout="this.style.color='white';">
                    <i class="fas fa-info-circle mr-2"></i>Learn More
                </a>
            </div>
        </div>
    </section>

@endsection
