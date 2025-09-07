@extends('layouts.usermenu')
@section('content')

<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --secondary-color: #F39C12;
    }

    .track-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1a252f, var(--primary-color));
        transform: translateY(-1px);
    }

    .input-group {
        position: relative;
    }

    .input-group input {
        padding-right: 3rem;
    }

    .input-group button {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
    }
</style>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    
    <!-- Page Header -->
    <div class="page-header pt-20 pb-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">
                <i class="fas fa-search-location mr-3" style="color: var(--secondary-color);"></i>
                Track Your Order
            </h1>
            <p class="text-blue-100 text-lg">Enter your tracking number to see the current status of your order</p>
            <div class="w-24 h-1 bg-white mx-auto mt-4 rounded-full opacity-80"></div>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-12 -mt-8">
        <div class="max-w-2xl mx-auto">
            
            <!-- Tracking Form -->
            <div class="track-card">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
                    <i class="fas fa-shipping-fast mr-3" style="color: var(--secondary-color);"></i>
                    Order Tracking
                </h3>
                
                <form action="{{ route('user.order.track') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-barcode mr-2" style="color: var(--secondary-color);"></i>
                            Tracking Number
                        </label>
                        <div class="input-group">
                            <input 
                                type="text" 
                                id="tracking_number" 
                                name="tracking_number" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-mono"
                                placeholder="Enter your tracking number (e.g., KT123456789)"
                                value="{{ old('tracking_number') }}"
                            >
                            <button type="submit" class="btn-primary px-4 py-2 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Your tracking number was provided in your order confirmation email
                        </p>
                    </div>
                </form>

                @if($errors->any())
                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">{{ $errors->first() }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Help Section -->
            <div class="track-card mt-8">
                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-question-circle mr-2" style="color: var(--secondary-color);"></i>
                    Need Help?
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-envelope text-blue-500 mt-1"></i>
                            <div>
                                <h5 class="font-medium text-gray-800">Check Your Email</h5>
                                <p class="text-sm text-gray-600">Your tracking number was sent to your email address when your order was confirmed.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-clock text-green-500 mt-1"></i>
                            <div>
                                <h5 class="font-medium text-gray-800">Processing Time</h5>
                                <p class="text-sm text-gray-600">Orders typically take 1-2 business days to process before shipping.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-history text-purple-500 mt-1"></i>
                            <div>
                                <h5 class="font-medium text-gray-800">Order History</h5>
                                <p class="text-sm text-gray-600">
                                    <a href="{{ route('user.orderhistory') }}" class="text-blue-600 hover:text-blue-800">
                                        View your order history
                                    </a> to find all your tracking numbers.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-phone text-orange-500 mt-1"></i>
                            <div>
                                <h5 class="font-medium text-gray-800">Contact Support</h5>
                                <p class="text-sm text-gray-600">Can't find your tracking number? Contact our support team for assistance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="text-center mt-8 space-x-4">
                <a href="{{ route('user.orderhistory') }}" 
                   class="btn-primary inline-flex items-center px-6 py-3 text-white rounded-lg font-semibold">
                    <i class="fas fa-history mr-2"></i>View Order History
                </a>
                
                <a href="{{ route('user.shop') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>

</body>
@endsection
