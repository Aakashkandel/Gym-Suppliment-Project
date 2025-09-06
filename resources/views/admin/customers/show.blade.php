@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.customers.index') }}" 
                   class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $customer->name }}</h1>
                    <p class="mt-2 text-gray-600">Customer #{{ $customer->id }} • Joined {{ $customer->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <button onclick="sendEmail()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Send Email
                </button>
                <button onclick="editCustomer()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Customer
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Customer Info & Stats -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Profile -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div class="mx-auto h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-blue-600">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $customer->name }}</h3>
                        <p class="text-gray-600">{{ $customer->email }}</p>
                        @if($customer->phone)
                            <p class="text-gray-600">{{ $customer->phone }}</p>
                        @endif
                    </div>

                    <div class="mt-6 border-t pt-6">
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Customer Since</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $customer->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Email Verified</dt>
                                <dd class="text-sm font-medium">
                                    @if($customer->email_verified_at)
                                        <span class="text-green-600">Yes</span>
                                    @else
                                        <span class="text-red-600">No</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Last Login</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    @if($customer->last_login_at)
                                        {{ $customer->last_login_at->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Customer Statistics -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Orders</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $totalOrders }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Spent</span>
                            <span class="text-2xl font-bold text-green-600">Rs {{ number_format($totalSpent, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Average Order</span>
                            <span class="text-lg font-semibold text-purple-600">Rs {{ number_format($avgOrderValue, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Items Purchased</span>
                            <span class="text-lg font-semibold text-orange-600">{{ $totalItems }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="sendPromotionalEmail()" 
                                class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-50 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Promotional Email
                        </button>
                        <button onclick="generateCoupon()" 
                                class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-50 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Generate Discount Coupon
                        </button>
                        <button onclick="viewActivity()" 
                                class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-50 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            View Activity Log
                        </button>
                    </div>
                </div>
            </div>

            <!-- Orders & Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order History -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Order History</h3>
                            <div class="flex items-center space-x-2">
                                <select id="order_status_filter" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                                    <option value="">All Orders</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $order->order_items_count }} items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Rs {{ number_format($order->total_amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($order->status === 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                                            <button onclick="updateOrderStatus({{ $order->id }})" 
                                                    class="text-green-600 hover:text-green-900">Update</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        No orders found for this customer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>

                <!-- Favorite Products -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Frequently Purchased Products</h3>
                    @if($favoriteProducts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($favoriteProducts as $product)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" 
                                     alt="{{ $product->title }}" class="w-12 h-12 rounded-lg object-cover">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $product->title }}</p>
                                    <p class="text-sm text-gray-500">Purchased {{ $product->purchase_count }} times</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rs {{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No frequently purchased products yet.</p>
                    @endif
                </div>

                <!-- Customer Notes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Notes</h3>
                        <button onclick="addNote()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">+ Add Note</button>
                    </div>
                    
                    <div id="notes-container" class="space-y-3">
                        @forelse($customer->notes ?? [] as $note)
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex justify-between items-start">
                                <p class="text-sm text-gray-900">{{ $note['content'] }}</p>
                                <button onclick="deleteNote({{ $loop->index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $note['created_at'] }} by {{ $note['created_by'] }}</p>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">No notes added yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div id="noteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Customer Note</h3>
            <form id="noteForm">
                <div class="mb-4">
                    <textarea id="note_content" name="content" rows="4" required
                              placeholder="Enter your note about this customer..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeNoteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancel</button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function sendEmail() {
    // Implement send email functionality
    alert('Send email functionality to be implemented');
}

function editCustomer() {
    // Implement edit customer functionality
    alert('Edit customer functionality to be implemented');
}

function sendPromotionalEmail() {
    // Implement promotional email functionality
    alert('Promotional email functionality to be implemented');
}

function generateCoupon() {
    // Implement coupon generation functionality
    alert('Coupon generation functionality to be implemented');
}

function viewActivity() {
    // Implement activity log functionality
    alert('Activity log functionality to be implemented');
}

function updateOrderStatus(orderId) {
    // Implement order status update functionality
    alert(`Update order status for order #${orderId}`);
}

function addNote() {
    document.getElementById('noteModal').classList.remove('hidden');
}

function closeNoteModal() {
    document.getElementById('noteModal').classList.add('hidden');
    document.getElementById('noteForm').reset();
}

function deleteNote(index) {
    if (confirm('Are you sure you want to delete this note?')) {
        // Implement note deletion
        alert(`Delete note at index ${index}`);
    }
}

document.getElementById('noteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(`/admin/customers/{{ $customer->id }}/notes`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error adding note');
        }
    });
});

// Order status filter
document.getElementById('order_status_filter').addEventListener('change', function() {
    // Implement order filtering
    const status = this.value;
    // Filter orders by status
});
</script>
@endsection
