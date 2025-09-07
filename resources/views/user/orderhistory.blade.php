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

    .order-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--secondary-color);
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

    .order-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-1px);
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }
</style>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    
    <!-- Page Header -->
    <div class="page-header pt-20 pb-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">
                <i class="fas fa-history mr-3" style="color: var(--secondary-color);"></i>
                Order History
            </h1>
            <p class="text-blue-100 text-lg">Track and manage all your supplement orders</p>
            <div class="w-24 h-1 bg-white mx-auto mt-4 rounded-full opacity-80"></div>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-12">
        <!-- Orders Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($orders as $order)
            <div class="order-card rounded-xl overflow-hidden">
                <!-- Card Header -->
                <div class="order-header p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold flex items-center">
                            <i class="fas fa-receipt mr-2"></i>
                            Order #{{$order->id}}
                        </h2>
                        <i class="fas fa-box opacity-80" style="color: var(--secondary-color);"></i>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-shopping-bag w-5 mr-3" style="color: var(--secondary-color);"></i>
                            <span class="font-medium">Items:</span>
                            <span class="ml-auto font-semibold">{{$order->items}} pcs ({{$order->products_count}} products)</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar-alt w-5 mr-3" style="color: var(--primary-color);"></i>
                            <span class="font-medium">Date:</span>
                            <span class="ml-auto text-sm">{{date('M d, Y', strtotime($order->order_date))}}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-credit-card w-5 mr-3" style="color: var(--secondary-color);"></i>
                            <span class="font-medium">Payment:</span>
                            <span class="ml-auto text-sm capitalize">{{$order->payment_method}}</span>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        @if($order->payment_status == 'pending')
                        <span class="status-badge status-pending">
                            <i class="fas fa-clock mr-1"></i>{{$order->payment_status}}
                        </span>
                        @elseif($order->payment_status == 'paid')
                        <span class="status-badge status-paid">
                            <i class="fas fa-check-circle mr-1"></i>{{$order->payment_status}}
                        </span>
                        @else
                        <span class="status-badge status-rejected">
                            <i class="fas fa-times-circle mr-1"></i>{{$order->payment_status}}
                        </span>
                        @endif
                    </div>

                    <!-- Total Amount -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Total Amount</span>
                            <span class="text-xl font-bold" style="color: var(--primary-color);">Rs {{number_format($order->total_amount, 2)}}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <a href="{{route('user.orderproduct',$order->id)}}" 
                           class="btn-primary w-full text-white py-3 px-4 rounded-lg text-center font-semibold flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>View Products
                        </a>
                        @if($order->payment_status == 'pending')
                        <a href="{{route('user.ordercancel',$order->id)}}" 
                           class="btn-secondary w-full text-white py-2 px-4 rounded-lg text-center font-semibold flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancel Order
                        </a>
                        @elseif($order->payment_status == 'rejected')
                        <a href="{{route('user.deleteorder',$order->id)}}" 
                           class="btn-secondary w-full text-white py-2 px-4 rounded-lg text-center font-semibold flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Delete Order
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($orders) == 0)
        <div class="text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">No Orders Found</h2>
                    <p class="text-gray-500 mb-6">You haven't placed any orders yet. Start shopping to see your order history here!</p>
                    <a href="{{route('user.shop')}}" 
                       class="inline-flex items-center px-6 py-3 rounded-lg font-semibold transition-all duration-300" 
                       style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: white;">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Start Shopping
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</body>
@endsection
