@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600 mt-1">Welcome back, Admin! Here's what's happening with your gym supplement store.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ now()->format('F j, Y') }}</span>
                    <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="bx bx-check text-white text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold">Rs {{ number_format($totalRevenue, 2) }}</p>
                        <p class="text-blue-100 text-xs mt-1">+{{ number_format($weeklyRevenue, 2) }} this week</p>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 rounded-lg p-3">
                        <i class="bx bx-dollar text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Orders</p>
                        <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                        <p class="text-green-100 text-xs mt-1">{{ $todayOrders }} today</p>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 rounded-lg p-3">
                        <i class="bx bx-shopping-bag text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Products</p>
                        <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                        <p class="text-purple-100 text-xs mt-1">{{ $lowStockProducts->count() }} low stock</p>
                    </div>
                    <div class="bg-purple-400 bg-opacity-30 rounded-lg p-3">
                        <i class="bx bx-package text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Customers -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Active Customers</p>
                        <p class="text-3xl font-bold">{{ $activeCustomers }}</p>
                        <p class="text-orange-100 text-xs mt-1">{{ $totalUsers }} total users</p>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 rounded-lg p-3">
                        <i class="bx bx-user text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-medium">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                    </div>
                    <i class="bx bx-time-five text-yellow-500 text-xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Processing</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $processingOrders }}</p>
                    </div>
                    <i class="bx bx-loader-alt text-blue-500 text-xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Delivered</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $deliveredOrders }}</p>
                    </div>
                    <i class="bx bx-check-circle text-green-500 text-xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-medium">Cancelled</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $cancelledOrders }}</p>
                    </div>
                    <i class="bx bx-x-circle text-red-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Sales Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Sales Overview</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Last 6 months</span>
                        <i class="bx bx-trending-up text-green-500"></i>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Best Selling Products -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Best Selling Products</h3>
                    <a href="{{ route('admin.product.index') }}" class="text-blue-600 text-sm hover:underline">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse($bestSellingProducts as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <p class="font-medium text-gray-900">{{ Str::limit($product->name, 20) }}</p>
                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ $product->carts_count ?? 0 }} sold</p>
                            <p class="text-sm text-gray-500">Rs {{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No sales data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Orders and Low Stock Alert -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                    <a href="{{ route('admin.order') }}" class="text-blue-600 text-sm hover:underline">View All Orders</a>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase">Order</th>
                                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="text-left py-3 px-2 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="text-right py-3 px-2 text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentOrders->take(5) as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-2">
                                    <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="text-sm text-gray-900">{{ $order->user->name }}</span>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-right">
                                    <span class="text-sm font-medium text-gray-900">Rs {{ number_format($order->total_amount, 2) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500">No recent orders</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Low Stock Alert</h3>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">
                        {{ $lowStockProducts->count() }} items
                    </span>
                </div>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @forelse($lowStockProducts as $product)
                    <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}" class="w-8 h-8 rounded object-cover">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ Str::limit($product->name, 25) }}</p>
                                <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-red-600">{{ $product->stock }} left</span>
                            <p class="text-xs text-gray-500">Rs {{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="bx bx-check-circle text-green-500 text-3xl mb-2"></i>
                        <p class="text-gray-500">All products are well stocked!</p>
                    </div>
                    @endforelse
                </div>
                @if($lowStockProducts->count() > 0)
                <div class="mt-4">
                    <a href="{{ route('admin.product.index') }}" class="block w-full text-center bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                        Manage Stock
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.product.create') }}" class="flex items-center justify-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition duration-200">
                    <i class="bx bx-plus-circle text-blue-600 text-xl mr-2"></i>
                    <span class="text-blue-600 font-medium">Add Product</span>
                </a>
                <a href="{{ route('admin.category.create') }}" class="flex items-center justify-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition duration-200">
                    <i class="bx bx-category text-green-600 text-xl mr-2"></i>
                    <span class="text-green-600 font-medium">Add Category</span>
                </a>
                <a href="{{ route('admin.order') }}" class="flex items-center justify-center p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition duration-200">
                    <i class="bx bx-list-ul text-purple-600 text-xl mr-2"></i>
                    <span class="text-purple-600 font-medium">View Orders</span>
                </a>
                <a href="{{ route('admin.user') }}" class="flex items-center justify-center p-4 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition duration-200">
                    <i class="bx bx-users text-orange-600 text-xl mr-2"></i>
                    <span class="text-orange-600 font-medium">Manage Users</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($monthlySales)->pluck('month')) !!},
        datasets: [{
            label: 'Revenue (Rs)',
            data: {!! json_encode(collect($monthlySales)->pluck('revenue')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rs ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endsection
