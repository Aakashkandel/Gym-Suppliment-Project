@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full">
    <div class="flex items-center justify-between w-full mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-700">Stock Management</h2>
            <p class="text-gray-600 mt-1">Monitor and manage product inventory levels</p>
        </div>
        <div class="flex items-center space-x-4">
            <button onclick="bulkUpdateStock()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Bulk Update
            </button>
            <button class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-500 hover:bg-gray-300">
                <i class="bx bx-refresh"></i>
            </button>
        </div>
    </div>

    <!-- Stock Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Low Stock Alert -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-red-700">Low Stock Alert</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $lowStockProducts->count() }}</p>
                    <p class="text-red-500 text-sm mt-1">Products below 10 units</p>
                </div>
                <div class="bg-red-100 rounded-lg p-3">
                    <i class="bx bx-error text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-orange-700">Out of Stock</h3>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $outOfStockProducts->count() }}</p>
                    <p class="text-orange-500 text-sm mt-1">Products with 0 units</p>
                </div>
                <div class="bg-orange-100 rounded-lg p-3">
                    <i class="bx bx-package text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Top Selling -->
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-700">Top Selling</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $topSellingProducts->count() }}</p>
                    <p class="text-green-500 text-sm mt-1">Fast-moving products</p>
                </div>
                <div class="bg-green-100 rounded-lg p-3">
                    <i class="bx bx-trending-up text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="showTab('low-stock')" id="low-stock-tab" class="tab-button py-2 px-1 border-b-2 border-red-500 font-medium text-sm text-red-600">
                Low Stock ({{ $lowStockProducts->count() }})
            </button>
            <button onclick="showTab('out-of-stock')" id="out-of-stock-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Out of Stock ({{ $outOfStockProducts->count() }})
            </button>
            <button onclick="showTab('top-selling')" id="top-selling-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Top Selling ({{ $topSellingProducts->count() }})
            </button>
        </nav>
    </div>

    <!-- Low Stock Tab -->
    <div id="low-stock-content" class="tab-content">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Low Stock Products</h3>
                <p class="text-sm text-gray-600 mt-1">Products with stock levels below 10 units</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lowStockProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($product->stock == 0) bg-red-100 text-red-800
                                    @elseif($product->stock < 5) bg-orange-100 text-orange-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $product->stock }} units
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rs {{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock == 0)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                @elseif($product->stock < 5)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Critical</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="updateStock({{ $product->id }}, '{{ $product->name }}')" class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700">
                                    Update Stock
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="bx bx-check-circle text-green-500 text-4xl mb-2"></i>
                                    <p>All products are well stocked!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Out of Stock Tab -->
    <div id="out-of-stock-content" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Out of Stock Products</h3>
                <p class="text-sm text-gray-600 mt-1">Products that are completely out of stock</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($outOfStockProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-lg object-cover opacity-50" src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rs {{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="updateStock({{ $product->id }}, '{{ $product->name }}')" class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                                    Restock Now
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="bx bx-check-circle text-green-500 text-4xl mb-2"></i>
                                    <p>No products are out of stock!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Selling Tab -->
    <div id="top-selling-content" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Selling Products</h3>
                <p class="text-sm text-gray-600 mt-1">Products with highest sales volume</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($topSellingProducts as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                    @if($index == 0) bg-yellow-100 text-yellow-800
                                    @elseif($index == 1) bg-gray-100 text-gray-800
                                    @elseif($index == 2) bg-orange-100 text-orange-800
                                    @else bg-blue-100 text-blue-800 @endif font-bold">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('images/product/'.$product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $product->sales_count ?? 0 }} sold
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($product->stock == 0) bg-red-100 text-red-800
                                    @elseif($product->stock < 10) bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $product->stock }} units
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="updateStock({{ $product->id }}, '{{ $product->name }}')" class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700">
                                    Restock
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="bx bx-bar-chart text-gray-400 text-4xl mb-2"></i>
                                    <p>No sales data available</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Update Stock Modal -->
<div id="updateStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Stock</h3>
                <button onclick="closeStockModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            <form id="updateStockForm" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input type="text" id="productName" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="newStock" class="block text-sm font-medium text-gray-700 mb-2">New Stock Quantity</label>
                        <input type="number" id="newStock" name="stock" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="stockNote" class="block text-sm font-medium text-gray-700 mb-2">Note (Optional)</label>
                        <textarea id="stockNote" name="note" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add a note about this stock update..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-4">
                    <button type="button" onclick="closeStockModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active styles from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-red-500', 'text-red-600', 'border-orange-500', 'text-orange-600', 'border-green-500', 'text-green-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Style active tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    
    if (tabName === 'low-stock') {
        activeTab.classList.add('border-red-500', 'text-red-600');
    } else if (tabName === 'out-of-stock') {
        activeTab.classList.add('border-orange-500', 'text-orange-600');
    } else if (tabName === 'top-selling') {
        activeTab.classList.add('border-green-500', 'text-green-600');
    }
}

// Update stock modal
function updateStock(productId, productName) {
    document.getElementById('productName').value = productName;
    document.getElementById('updateStockForm').action = `/stock/update/${productId}`;
    document.getElementById('updateStockModal').classList.remove('hidden');
}

function closeStockModal() {
    document.getElementById('updateStockModal').classList.add('hidden');
    document.getElementById('updateStockForm').reset();
}

// Bulk update functionality
function bulkUpdateStock() {
    alert('Bulk update functionality would be implemented here');
}

// Auto-refresh every 5 minutes
setInterval(() => {
    location.reload();
}, 300000);
</script>
@endsection
