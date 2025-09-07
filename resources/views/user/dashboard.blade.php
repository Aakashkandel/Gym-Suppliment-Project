@extends('layouts.usermenu')
@section('content')
<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --secondary-color: #F39C12;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dashboard-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        padding: 2rem;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .stat-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-color);
    }

    .quick-action-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .quick-action-btn:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(44, 62, 80, 0.3);
    }

    .quick-action-btn.secondary {
        background: linear-gradient(135deg, var(--secondary-color), #e67e22);
    }

    .quick-action-btn.secondary:hover {
        background: linear-gradient(135deg, #e67e22, var(--secondary-color));
        box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
    }

    .recent-order-card {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .recent-order-card:hover {
        border-color: var(--secondary-color);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .status-pending { background: linear-gradient(135deg, var(--warning-color), #f97316); color: white; }
    .status-processing { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
    .status-shipped { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .status-delivered { background: linear-gradient(135deg, var(--success-color), #059669); color: white; }
    .status-cancelled { background: linear-gradient(135deg, var(--danger-color), #dc2626); color: white; }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .dashboard-card {
            padding: 1.5rem;
            margin: 0 0.5rem;
        }
    }

    .welcome-section {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
</style>

<div class="dashboard-container">
    <div class="container mx-auto max-w-7xl px-4">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="flex items-center justify-between flex-wrap">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-blue-100">Here's what's happening with your account today.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-right">
                        <div class="text-2xl font-bold">{{ now()->format('d') }}</div>
                        <div class="text-sm">{{ now()->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    </div>
                    <div class="icon-wrapper bg-blue-100">
                        <i class="bx bx-shopping-bag text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pending Orders</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
                    </div>
                    <div class="icon-wrapper bg-yellow-100">
                        <i class="bx bx-time text-yellow-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Cart Items</p>
                        <p class="text-2xl font-bold text-green-600">{{ $cartItems }}</p>
                    </div>
                    <div class="icon-wrapper bg-green-100">
                        <i class="bx bx-cart text-green-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Spent</p>
                        <p class="text-2xl font-bold text-purple-600">Rs {{ number_format($totalSpent, 2) }}</p>
                    </div>
                    <div class="icon-wrapper bg-purple-100">
                        <i class="bx bx-money text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="dashboard-card">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="bx bx-flash text-blue-600 mr-2"></i>
                        Quick Actions
                    </h3>
                    
                    <div class="space-y-4">
                        <a href="{{ route('user.shop') }}" class="quick-action-btn w-full justify-center">
                            <i class="bx bx-store"></i>
                            Browse Products
                        </a>
                        
                        <a href="{{ route('user.cart') }}" class="quick-action-btn secondary w-full justify-center">
                            <i class="bx bx-cart"></i>
                            View Cart ({{ $cartItems }})
                        </a>
                        
                        <a href="{{ route('user.orderhistory') }}" class="quick-action-btn w-full justify-center">
                            <i class="bx bx-history"></i>
                            Order History
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="quick-action-btn secondary w-full justify-center">
                            <i class="bx bx-user"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="dashboard-card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="bx bx-receipt text-green-600 mr-2"></i>
                            Recent Orders
                        </h3>
                        <a href="{{ route('user.orderhistory') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            View All
                        </a>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                            <div class="recent-order-card">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4">
                                            <div>
                                                <div class="font-semibold text-gray-800">Order #{{ $order->id }}</div>
                                                <div class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-600">Total Amount</div>
                                                <div class="font-bold text-gray-800">Rs {{ number_format($order->total_amount, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <a href="{{ route('user.order.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="bx bx-shopping-bag text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">No orders yet</h3>
                            <p class="text-gray-400 mb-4">Start shopping to see your orders here</p>
                            <a href="{{ route('user.shop') }}" class="quick-action-btn">
                                <i class="bx bx-store"></i>
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Account Overview -->
            <div class="dashboard-card">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="bx bx-user-circle text-purple-600 mr-2"></i>
                    Account Overview
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Email</span>
                        <span class="font-medium">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Member Since</span>
                        <span class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Last Login</span>
                        <span class="font-medium">{{ now()->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-gray-600">Account Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="bx bx-check-circle mr-1"></i>
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="dashboard-card">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="bx bx-bell text-orange-600 mr-2"></i>
                    Recent Activity
                </h3>
                
                <div class="space-y-4">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders->take(3) as $order)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="bx bx-shopping-bag text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Order #{{ $order->id }}</span> was {{ $order->status }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-bell-off text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
