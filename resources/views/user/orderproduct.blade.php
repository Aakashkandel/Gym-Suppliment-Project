@extends('layouts.usermenu')

@section('content')
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
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--secondary-color);
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .price-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
    }

    .quantity-badge {
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .total-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-weight: 700;
        text-align: center;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .btn-back {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-2px);
    }

    .summary-card {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .status-pending {
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
        color: #ffffff;
    }

    .status-paid {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
    }

    .status-rejected {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
    }
</style>

<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Page Header -->
    <div class="page-header pt-20 pb-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold mb-4">
                    <i class="fas fa-box-open mr-3" style="color: var(--secondary-color);"></i>
                    Order #{{$order->id}} Details
                </h1>
                <p class="text-blue-100 text-lg">Ordered on {{date('M d, Y', strtotime($order->order_date))}}</p>
                <div class="w-24 h-1 bg-white mx-auto mt-4 rounded-full opacity-80"></div>
            </div>

            <!-- Order Status and Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-center">
                        <i class="fas fa-receipt text-3xl mb-3" style="color: var(--secondary-color);"></i>
                        <h3 class="font-bold" style="color: var(--primary-color);">Payment Status</h3>
                        @if($order->payment_status == 'pending')
                        <span class="status-badge status-pending mt-2 inline-block">
                            <i class="fas fa-clock mr-1"></i>{{$order->payment_status}}
                        </span>
                        @elseif($order->payment_status == 'paid')
                        <span class="status-badge status-paid mt-2 inline-block">
                            <i class="fas fa-check-circle mr-1"></i>{{$order->payment_status}}
                        </span>
                        @else
                        <span class="status-badge status-rejected mt-2 inline-block">
                            <i class="fas fa-times-circle mr-1"></i>{{$order->payment_status}}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-center">
                        <i class="fas fa-shopping-bag text-3xl mb-3" style="color: var(--secondary-color);"></i>
                        <h3 class="font-bold" style="color: var(--primary-color);">Total Items</h3>
                        <p class="text-2xl font-bold mt-2" style="color: var(--secondary-color);">{{$orderSummary['total_items']}}</p>
                        <p class="text-sm text-gray-600">{{$orderSummary['total_products']}} Products</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-center">
                        <i class="fas fa-money-bill-wave text-3xl mb-3" style="color: var(--secondary-color);"></i>
                        <h3 class="font-bold" style="color: var(--primary-color);">Total Amount</h3>
                        <p class="text-2xl font-bold mt-2" style="color: var(--secondary-color);">Rs {{number_format($order->total_amount, 2)}}</p>
                        <p class="text-sm text-gray-600">{{ucfirst($order->payment_method)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container mx-auto px-4 pb-12">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-center mb-2" style="color: var(--primary-color);">Ordered Products</h2>
            <div class="w-20 h-1 mx-auto rounded-full" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($cart_items as $cart)
            <div class="product-card rounded-xl overflow-hidden">
                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    <img src="{{ asset('images/' . $cart->product->image) }}" 
                         class="product-image w-full h-48 object-cover" 
                         alt="{{ $cart->product->name }}">
                    <div class="absolute top-3 right-3">
                        <span class="quantity-badge">
                            <i class="fas fa-hashtag mr-1"></i>{{ $cart->quantity }}
                        </span>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="bg-white text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">
                            {{$cart->product->category->name ?? 'General'}}
                        </span>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="p-4 space-y-3">
                    <h3 class="text-lg font-bold line-clamp-2" style="color: var(--primary-color);">{{ $cart->product->name }}</h3>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 font-medium">Unit Price:</span>
                        <span class="price-badge">Rs {{ number_format($cart->product->price, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 font-medium">Quantity:</span>
                        <span class="font-bold" style="color: var(--secondary-color);">{{ $cart->quantity }} pcs</span>
                    </div>

                    <div class="pt-2">
                        <div class="total-badge">
                            <div class="flex items-center justify-between">
                                <span>Subtotal:</span>
                                <span class="text-lg">Rs {{ number_format($cart->price * $cart->quantity, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="max-w-md mx-auto mt-12">
            <div class="summary-card rounded-2xl p-6">
                <h3 class="text-xl font-bold mb-4 text-center">Order Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Total Products:</span>
                        <span class="font-semibold">{{$orderSummary['total_products']}}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Items:</span>
                        <span class="font-semibold">{{$orderSummary['total_items']}}</span>
                    </div>
                    <div class="border-t border-white border-opacity-20 pt-3">
                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Grand Total:</span>
                            <span class="font-bold">Rs {{number_format($order->total_amount, 2)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-12">
            <a href="{{route('user.orderhistory')}}" 
               class="inline-flex items-center px-6 py-3 btn-back rounded-lg font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Order History
            </a>
        </div>
    </div>
</div>
@endsection
