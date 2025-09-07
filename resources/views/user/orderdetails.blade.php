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

    .order-status-timeline {
        position: relative;
    }

    .timeline-step {
        position: relative;
        padding-left: 3rem;
        padding-bottom: 2rem;
    }

    .timeline-step:last-child {
        padding-bottom: 0;
    }

    .timeline-step::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 2rem;
        bottom: -1rem;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-step:last-child::before {
        display: none;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .timeline-icon.completed {
        background: var(--secondary-color);
        color: white;
    }

    .timeline-icon.pending {
        background: #e5e7eb;
        color: #9ca3af;
    }

    .product-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .status-pending { background: linear-gradient(135deg, #f59e0b, #f97316); color: white; }
    .status-processing { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
    .status-shipped { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .status-delivered { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .status-cancelled { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .info-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-1px);
    }
</style>
    }

    .timeline-icon.completed {
        background: var(--success-color);
    }

    .timeline-icon.pending {
        background: #e5e7eb;
        color: #6b7280;
    }

    .progress-bar {
        height: 8px;
        background: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--success-color), var(--secondary-color));
        transition: width 0.3s ease;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-shipped { background: #e0e7ff; color: #5b21b6; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Details</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span>Order #{{ $order->id }}</span>
                        <span>•</span>
                        <span>{{ $order->created_at->format('M d, Y at h:i A') }}</span>
                        @if($order->tracking_number)
                        <span>•</span>
                        <span>Tracking: {{ $order->tracking_number }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mt-2">
                        Rs {{ number_format($order->total_amount, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Order Timeline -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Progress</h2>
                    
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress</span>
                            <span>{{ $order->progress_percentage }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $order->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="order-timeline">
                        @foreach($order->status_timeline as $step)
                        <div class="timeline-step">
                            <div class="timeline-icon {{ $step['completed'] ? 'completed' : 'pending' }}">
                                <i class="bx {{ $step['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h3 class="font-semibold text-gray-900">{{ $step['label'] }}</h3>
                                <p class="text-sm text-gray-600">
                                    @if($step['completed'])
                                        {{ $step['date']->format('M d, Y at h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($order->status === 'shipped' && $order->estimated_delivery)
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-900">Estimated Delivery</h4>
                        <p class="text-blue-700">{{ $order->estimated_delivery->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>

                <!-- Order Information -->
                <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-medium capitalize">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status</span>
                            <span class="font-medium capitalize {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items</span>
                            <span class="font-medium">{{ $orderSummary['total_items'] }} items</span>
                        </div>
                        @if($order->notes)
                        <div class="pt-3 border-t">
                            <span class="text-gray-600">Notes</span>
                            <p class="text-sm text-gray-700 mt-1">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Items</h2>
                    
                    <div class="space-y-4">
                        @foreach($cart_items as $item)
                        <div class="product-card p-4 border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset('images/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="bx bx-package text-gray-400 text-2xl"></i>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $item->product ? $item->product->name : 'Product not found' }}
                                    </h3>
                                    @if($item->product)
                                    <p class="text-sm text-gray-600">{{ $item->product->category->name ?? 'No category' }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-600">Qty: {{ $item->quantity }}</span>
                                        <span class="text-sm text-gray-600">Price: Rs {{ number_format($item->price, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <div class="text-lg font-semibold text-gray-900">
                                        Rs {{ number_format($item->quantity * $item->price, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center text-lg font-semibold">
                                <span>Total Amount</span>
                                <span class="text-2xl" style="color: var(--primary-color);">
                                    Rs {{ number_format($order->total_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('user.orderhistory') }}" 
                           class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg text-center font-semibold hover:bg-gray-700 transition-colors">
                            <i class="bx bx-arrow-back mr-2"></i>Back to Orders
                        </a>
                        
                        @if($order->can_be_cancelled)
                        <a href="{{ route('user.ordercancel', $order->id) }}" 
                           class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg text-center font-semibold hover:bg-red-700 transition-colors"
                           onclick="return confirm('Are you sure you want to cancel this order?')">
                            <i class="bx bx-x mr-2"></i>Cancel Order
                        </a>
                        @endif
                        
                        @if($order->payment_status === 'rejected')
                        <a href="{{ route('user.deleteorder', $order->id) }}" 
                           class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg text-center font-semibold hover:bg-gray-700 transition-colors"
                           onclick="return confirm('Are you sure you want to delete this order?')">
                            <i class="bx bx-trash mr-2"></i>Delete Order
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
