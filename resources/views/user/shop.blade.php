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
    <section class="relative text-white min-h-[50vh] flex items-center" style="background-image: url('{{ asset('clientimage/gym_herosection.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="hero-overlay"></div>

        <div class="container mx-auto text-center relative z-10 py-16 px-4">
            <i class="fas fa-dumbbell text-6xl mb-6" style="color: #ffffff;"></i>
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="color: #ffffff;">
                <i class="fas fa-fire mr-3"></i>Premium Gym Supplements
            </h1>
            <p class="text-xl mb-8" style="color: rgba(255,255,255,0.95);">
                <i class="fas fa-heartbeat mr-2"></i>Fuel your fitness journey with top-quality supplements
            </p>

            <form action="{{route('user.search')}}" method="get" class="max-w-2xl mx-auto">
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                          <input type="text" name="search" 
                              class="w-full py-4 pl-14 pr-32 rounded-full border-0 focus:outline-none focus:ring-4 text-lg shadow-2xl bg-white text-black placeholder-gray-500" 
                              style="focus:ring-color: var(--secondary-color); focus:ring-opacity: 0.5;"
                              placeholder="Search for protein powder, pre-workout, creatine, vitamins...">
                    <button type="submit" 
                            class="search-btn absolute right-2 top-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-lg">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 filter-gradient">
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-filter mr-3"></i>Shop Our Products
                </h2>

                
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
            <div class="product-card bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl p-4">
                    <img src="{{ $product->main_image ?? asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="w-full h-48 object-contain bg-gray-100 rounded-lg">
                

                <h3 class="mt-3 font-semibold text-lg" style="color: var(--primary-color);">{{ $product->name }}</h3>
                <p class="text-gray-600">Rs. {{ number_format($product->price) }}</p>

                <div class="mt-3 grid grid-cols-2 gap-3">
                    <a href="{{ route('user.productdetails', $product->id) }}" class="text-center px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">View Details</a>
                    @auth
                    <form method="POST" action="{{ route('productdetails.store') }}" class="m-0">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="price" value="{{ $product->price }}">
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