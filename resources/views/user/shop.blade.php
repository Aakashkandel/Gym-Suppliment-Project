@extends('layouts.usermenu')
@section('content')

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --primary-dark: #1a252f;
        --secondary-color: #F39C12;
        --secondary-light: #f4a62a;
        --secondary-dark: #d68910;
    }
    
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(44, 62, 80, 0.2), 0 10px 10px -5px rgba(44, 62, 80, 0.1);
        border-color: var(--primary-color);
    }
    .search-container {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    }
    .filter-gradient {
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-dark) 100%);
        color: var(--primary-color);
    }
    .btn-primary {
        background: var(--primary-color);
        transition: all 0.3s ease;
        color: var(--secondary-color);
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(44, 62, 80, 0.4);
    }
    .price-tag {
        background: var(--secondary-color);
        color: var(--primary-color);
        font-weight: bold;
    }
    .category-filter {
        background: var(--secondary-color);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }
    .category-filter:hover {
        background: var(--primary-color);
        color: var(--secondary-color);
    }
    .search-btn {
        background: var(--secondary-color);
        color: var(--primary-color);
    }
    .search-btn:hover {
        background: var(--secondary-dark);
    }
</style>

<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section with Search -->
    <div class="search-container py-16 px-4">
        <div class="container mx-auto text-center">
            <i class="fas fa-dumbbell text-6xl mb-6" style="color: var(--secondary-color);"></i>
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="color: var(--secondary-color);">
                <i class="fas fa-fire mr-3"></i>Premium Gym Supplements
            </h1>
            <p class="text-xl mb-8" style="color: var(--secondary-color); opacity: 0.9;">
                <i class="fas fa-heartbeat mr-2"></i>Fuel your fitness journey with top-quality supplements
            </p>
            
            <!-- Search Form -->
            <form action="{{route('user.search')}}" method="get" class="max-w-2xl mx-auto">
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" name="search" 
                           class="w-full py-4 pl-14 pr-32 rounded-full border-0 focus:outline-none focus:ring-4 text-lg shadow-2xl" 
                           style="focus:ring-color: var(--secondary-color); focus:ring-opacity: 0.5;"
                           placeholder="Search for protein powder, pre-workout, creatine, vitamins...">
                    <button type="submit" 
                            class="search-btn absolute right-2 top-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-lg">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Fitness Features Banner -->
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

    <!-- Filters and Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 filter-gradient">
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-filter mr-3"></i>Shop Our Products
                </h2>

                
                <!-- Category Filter -->
                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <label class="font-semibold flex items-center">
                        <i class="fas fa-th-large mr-2"></i>Filter by Category:
                    </label>
                    <div class="relative">
                        <select id="categoryFilter" 
                                class="category-filter block appearance-none px-6 py-3 pr-10 rounded-lg leading-tight focus:outline-none focus:ring-4 shadow-lg min-w-48 transition-all duration-300"
                                style="focus:ring-color: var(--primary-color); focus:ring-opacity: 0.3;">
                            <option value="">
                                <i class="fas fa-list mr-2"></i>All Categories
                            </option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                            <i class="fas fa-chevron-down" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-12">
            @foreach($products as $product)
            <div class="product-card bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl">
                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    <img src="{{asset('images/product/'.$product->image)}}" 
                         class="w-full h-48 sm:h-56 object-cover transition-transform duration-300 hover:scale-110" 
                         alt="{{$product->name}}">
                    <div class="absolute top-3 right-3">
                        <span class="price-tag text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                            ₹{{number_format($product->price)}}
                        </span>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="p-4 sm:p-5">
                    <h3 class="text-lg sm:text-xl font-bold mb-2 line-clamp-2" style="color: var(--primary-color);">
                        <i class="fas fa-dumbbell mr-2 text-sm" style="color: var(--secondary-color); background: var(--primary-color); padding: 4px; border-radius: 50%;"></i>
                        {{$product->name}}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        @if(stripos($product->name, 'protein') !== false)
                            <i class="fas fa-fire mr-1"></i>Premium protein powder for muscle growth and recovery
                        @elseif(stripos($product->name, 'pre-workout') !== false || stripos($product->name, 'preworkout') !== false)
                            <i class="fas fa-bolt mr-1"></i>High-energy pre-workout formula for maximum performance
                        @elseif(stripos($product->name, 'creatine') !== false)
                            <i class="fas fa-muscle mr-1"></i>Pure creatine for strength and explosive power gains
                        @elseif(stripos($product->name, 'bcaa') !== false || stripos($product->name, 'amino') !== false)
                            <i class="fas fa-dna mr-1"></i>Essential amino acids for muscle recovery and endurance
                        @elseif(stripos($product->name, 'vitamin') !== false || stripos($product->name, 'multivitamin') !== false)
                            <i class="fas fa-pills mr-1"></i>Complete vitamin complex for overall health and wellness
                        @elseif(stripos($product->name, 'fat') !== false || stripos($product->name, 'burn') !== false)
                            <i class="fas fa-fire-alt mr-1"></i>Advanced fat burner for lean muscle and weight management
                        @elseif(stripos($product->name, 'mass') !== false || stripos($product->name, 'gainer') !== false)
                            <i class="fas fa-chart-line mr-1"></i>High-calorie mass gainer for rapid muscle building
                        @else
                            <i class="fas fa-heartbeat mr-1"></i>Premium supplement for enhanced fitness performance
                        @endif
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{route('user.productdetails',$product->id)}}" 
                           class="btn-primary text-center py-2 sm:py-3 px-4 rounded-lg font-semibold transition-all duration-300 hover:shadow-lg flex-1">
                            <i class="fas fa-info-circle mr-2"></i>View Details
                        </a>
                        <button class="category-filter py-2 sm:py-3 px-4 rounded-lg font-semibold transition-all duration-300 hover:shadow-lg">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Products Message -->
        @if($products->isEmpty())
        <div class="text-center py-16">
            <div class="bg-white rounded-xl shadow-lg p-12 max-w-md mx-auto" style="border: 2px solid var(--secondary-color);">
                <i class="fas fa-dumbbell text-6xl mb-4" style="color: var(--primary-color);"></i>
                <h3 class="text-2xl font-bold mb-2" style="color: var(--primary-color);">No Supplements Found</h3>
                <p class="text-gray-600 mb-6">
                    <i class="fas fa-search mr-2"></i>Try adjusting your search criteria or browse all supplement categories.
                </p>
                <a href="{{ route('user.shop') }}" class="btn-primary py-3 px-6 rounded-lg font-semibold transition-all duration-300 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Back to All Supplements
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Category Filter Script -->
<script>
    document.getElementById('categoryFilter').addEventListener('change', function() {
        var categoryId = this.value;
        
        // Add loading animation
        this.style.opacity = '0.6';
        this.disabled = true;
        
        setTimeout(() => {
            if (categoryId) {
                window.location.href = "{{ route('user.categorysearch', '') }}/" + categoryId;
            } else {
                window.location.href = "{{ route('user.shop') }}";
            }
        }, 300);
    });

    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';

    // Add loading animation for images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.5s ease';
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });

        // Add hover effects for product cards
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add search input focus enhancement
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.boxShadow = '0 25px 50px -12px rgba(44, 62, 80, 0.3)';
            });
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
                this.parentElement.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1)';
            });
        }
    });
</script>

@endsection