@extends('layouts.app')
@section('content')
<div class="flex flex-col w-full">
    <div class="flex items-center justify-between w-full mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-700">Order Management</h2>
            <p class="text-gray-600 mt-1">Manage and track all customer orders</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Filter Dropdown -->
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Orders</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-500 hover:bg-gray-300">
                <i class="bx bx-search"></i>
            </button>
        </div>
    </div>

    <!-- Order Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-medium">Pending</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
                <i class="bx bx-time-five text-yellow-500 text-xl"></i>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Processing</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $orders->where('status', 'processing')->count() }}</p>
                </div>
                <i class="bx bx-loader-alt text-blue-500 text-xl"></i>
            </div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-600 text-sm font-medium">Shipped</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $orders->where('status', 'shipped')->count() }}</p>
                </div>
                <i class="bx bx-package text-purple-500 text-xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Delivered</p>
                    <p class="text-2xl font-bold text-green-700">{{ $orders->where('status', 'delivered')->count() }}</p>
                </div>
                <i class="bx bx-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-medium">Cancelled</p>
                    <p class="text-2xl font-bold text-red-700">{{ $orders->where('status', 'cancelled')->count() }}</p>
                </div>
                <i class="bx bx-x-circle text-red-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Orders List</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 order-row" data-status="{{ $order->status }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                            <div class="text-sm text-gray-500">{{ $order->payment_method }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="bx bx-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @php
                                    $cartIds = json_decode($order->cart_ids);
                                    $itemCount = count($cartIds);
                                @endphp
                                {{ $itemCount }} {{ Str::plural('item', $itemCount) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($order->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->payment_status == 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status == 'failed') bg-red-100 text-red-800
                                @elseif($order->payment_status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rs {{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <!-- View Details -->
                                <button onclick="viewOrderDetails({{ $order->id }})" class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <i class="bx bx-show"></i>
                                </button>
                                
                                <!-- Update Status -->
                                @if($order->status != 'delivered' && $order->status != 'cancelled')
                                <div class="relative">
                                    <select onchange="updateOrderStatus({{ $order->id }}, this.value)" class="text-sm border border-gray-300 rounded px-2 py-1">
                                        <option value="">Update Status</option>
                                        @if($order->status == 'pending')
                                            <option value="processing">Mark as Processing</option>
                                        @endif
                                        @if($order->status == 'processing')
                                            <option value="shipped">Mark as Shipped</option>
                                        @endif
                                        @if($order->status == 'shipped')
                                            <option value="delivered">Mark as Delivered</option>
                                        @endif
                                        @if(in_array($order->status, ['pending', 'processing']))
                                            <option value="cancelled">Cancel Order</option>
                                        @endif
                                    </select>
                                </div>
                                @endif

                                <!-- Payment Actions -->
                                @if($order->payment_status == 'pending')
                                <a href="{{route('admin.order.accept', $order->id)}}" class="text-green-600 hover:text-green-900" title="Accept Payment">
                                    <i class="bx bx-check"></i>
                                </a>
                                <button onclick="showRejectPopup({{ $order->id }})" class="text-red-600 hover:text-red-900" title="Reject Order">
                                    <i class="bx bx-x"></i>
                                </button>
                                @endif

                                <!-- Download Invoice -->
                                @if($order->payment_status == 'paid')
                                <a href="{{ route('admin.order.invoice', $order->id) }}" class="text-purple-600 hover:text-purple-900" title="Download Invoice" target="_blank">
                                    <i class="bx bx-download"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
                <button onclick="closeOrderDetails()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            <div id="orderDetailsContent" class="p-6">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Reject Order Confirmation Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Order</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to reject this order? This action cannot be undone and the stock will be restored.</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <a id="confirmRejectLink" href="#" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Reject Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter orders by status
document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value;
    const rows = document.querySelectorAll('.order-row');
    
    rows.forEach(row => {
        if (selectedStatus === '' || row.dataset.status === selectedStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Update order status
function updateOrderStatus(orderId, status) {
    if (status) {
        fetch(`/order/status/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// View order details
function viewOrderDetails(orderId) {
    // This would typically fetch order details via AJAX
    document.getElementById('orderDetailsModal').classList.remove('hidden');
    // Load order details content here
}

function closeOrderDetails() {
    document.getElementById('orderDetailsModal').classList.add('hidden');
}

// Reject order modal
function showRejectPopup(orderId) {
    document.getElementById('confirmRejectLink').href = `/order/reject/${orderId}`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
