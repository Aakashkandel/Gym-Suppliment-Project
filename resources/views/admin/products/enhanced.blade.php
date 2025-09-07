@extends('layouts.app')

@section('content')
<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #1cc88a, #13855c);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #f6c23e, #dda20a);
}

.bg-gradient-danger {
    background: linear-gradient(45deg, #e74a3b, #c0392b);
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: none;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

.modal-xl {
    max-width: 1200px;
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}
</style>
<div class="container-fluid px-6 py-4">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Enhanced Product Management</h1>
                <p class="text-gray-600">Manage your gym supplements with advanced features</p>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center transition-colors duration-200" onclick="resetToAddMode()" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-2"></i>Add New Product
            </button>
        </div>
        
        <!-- Breadcrumb -->
        <nav class="mt-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right mx-2"></i></li>
                <li class="text-gray-900 font-medium">Enhanced Products</li>
            </ol>
        </nav>
    </div>

    <!-- Product Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Products</p>
                    <p class="text-3xl font-bold">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-box-open text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Featured Products</p>
                    <p class="text-3xl font-bold">{{ $featuredProducts ?? 0 }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-star text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium uppercase tracking-wide">Low Stock</p>
                    <p class="text-3xl font-bold">{{ $lowStockCount ?? 0 }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium uppercase tracking-wide">Out of Stock</p>
                    <p class="text-3xl font-bold">{{ $outOfStockCount ?? 0 }}</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-lg px-6 py-4">
            <h6 class="text-lg font-semibold flex items-center">
                <i class="fas fa-filter mr-2"></i>Filters & Search
            </h6>
        </div>
        <div class="p-6">
            <form id="filterForm" method="GET" action="{{ route('admin.products.enhanced') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   id="search" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU...">
                        </div>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="bestseller" {{ request('status') == 'bestseller' ? 'selected' : '' }}>Best Seller</option>
                        </select>
                    </div>
                    <div>
                        <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-2">Stock Status</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                id="stock_status" name="stock_status">
                            <option value="">All Stock</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <div class="flex gap-2">
                            <select class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Latest</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Stock</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('admin.products.enhanced') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times mr-2"></i>Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-lg px-6 py-4 flex justify-between items-center">
            <h6 class="text-lg font-semibold flex items-center">
                <i class="fas fa-table mr-2"></i>Products List
            </h6>
            <div class="text-blue-100">
                @if(isset($products))
                    {{ $products->total() }} total products
                @endif
            </div>
        </div>
        <div class="overflow-hidden">
            @if(isset($products) && $products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Product Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Features</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-44">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products ?? collect() as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0">
                                    <img class="h-16 w-16 rounded-lg object-cover" 
                                         src="{{ $product->image ? asset('images/'.$product->image) : asset('images/placeholder.jpg') }}" 
                                         alt="{{ $product->name }}">
                                    @if(isset($product->additional_images) && count(json_decode($product->additional_images, true) ?? []) > 0)
                                        <span class="text-xs text-gray-500 mt-1 block">+{{ count(json_decode($product->additional_images, true)) }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    @if($product->sku)
                                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    @endif
                                    @if(isset($product->tags) && $product->tags)
                                        <div class="mt-1 flex flex-wrap gap-1">
                                            @foreach(json_decode($product->tags, true) ?? [] as $tag)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->category->name ?? 'No Category' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                        <div class="text-sm text-gray-500 line-through">Rs {{ number_format($product->price, 2) }}</div>
                                        <div class="text-sm font-medium text-green-600">Rs {{ number_format($product->discount_price, 2) }}</div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                                        </span>
                                    @else
                                        <div class="text-sm font-medium text-gray-900">Rs {{ number_format($product->price, 2) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= ($product->min_stock_level ?? 10) ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ $product->stock }}
                                    </span>
                                    @if($product->min_stock_level)
                                        <div class="text-xs text-gray-500">Min: {{ $product->min_stock_level }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($product->is_active ?? true)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                    @endif
                                    @if($product->is_featured ?? false)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Featured</span>
                                    @endif
                                    @if($product->is_bestseller ?? false)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Best Seller</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>
                                    @if(isset($product->flavors) && $product->flavors)
                                        <div><strong>Flavors:</strong> {{ count(json_decode($product->flavors, true) ?? []) }}</div>
                                    @endif
                                    @if(isset($product->sizes) && $product->sizes)
                                        <div><strong>Sizes:</strong> {{ count(json_decode($product->sizes, true) ?? []) }}</div>
                                    @endif
                                    @if(isset($product->ingredients) && $product->ingredients)
                                        <div><strong>Ingredients:</strong> ✓</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button" class="text-blue-600 hover:text-blue-900" 
                                            onclick="viewProduct({{ $product->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="text-green-600 hover:text-green-900" 
                                            onclick="editProduct({{ $product->id }}); console.log('Edit button clicked for product {{ $product->id }}');" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="text-red-600 hover:text-red-900" 
                                            onclick="deleteProduct({{ $product->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-box-open text-6xl mb-4 text-blue-500"></i>
                                    <h5 class="text-xl font-medium mb-2">No products found</h5>
                                    <p class="mb-4">No products match your current search criteria.</p>
                                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" onclick="resetToAddMode()" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                        <i class="fas fa-plus mr-2"></i>Add Your First Product
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-gray-500">
                    <i class="fas fa-box-open text-6xl mb-4 text-blue-500"></i>
                    <h5 class="text-xl font-medium mb-2">No products available</h5>
                    <p class="mb-4">Get started by adding your first product.</p>
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" onclick="resetToAddMode()" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus mr-2"></i>Add Your First Product
                    </button>
                </div>
            </div>
            @endif
            
            <!-- Pagination -->
            @if(isset($products) && method_exists($products, 'links') && $products->hasPages())
                <div class="flex justify-center py-4 border-t border-gray-200">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="text-primary mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Basic Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Product Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" required 
                                               placeholder="Enter product name">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Product Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" required 
                                               placeholder="Enter product title">
                                        <div class="form-text">This will be used as the display title</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="sku" class="form-label fw-bold">SKU</label>
                                        <input type="text" class="form-control" id="sku" name="sku" 
                                               placeholder="Auto-generated if left empty">
                                        <div class="form-text">Leave empty for auto-generation</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" 
                                                  placeholder="Enter product description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing & Stock -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="text-primary mb-0">
                                        <i class="fas fa-rupee-sign me-2"></i>Pricing & Stock
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label fw-bold">Regular Price *</label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required
                                                   placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="discount_price" class="form-label">Discount Price</label>
                                            <input type="number" class="form-control" id="discount_price" name="discount_price" step="0.01" min="0"
                                                   placeholder="0.00">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="stock" class="form-label fw-bold">Stock Quantity *</label>
                                            <input type="number" class="form-control" id="stock" name="stock" min="0" required
                                                   placeholder="0">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="min_stock_level" class="form-label">Min Stock Alert</label>
                                            <input type="number" class="form-control" id="min_stock_level" name="min_stock_level" min="0" value="10"
                                                   placeholder="10">
                                            <div class="form-text">Alert when stock goes below this level</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Product Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                            <label class="form-check-label" for="is_featured">Featured Product</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Details Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="text-primary mb-0">
                                        <i class="fas fa-cogs me-2"></i>Additional Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="weight" class="form-label">Weight</label>
                                            <input type="text" class="form-control" id="weight" name="weight" 
                                                   placeholder="e.g., 2kg, 500g">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="dimensions" class="form-label">Dimensions</label>
                                            <input type="text" class="form-control" id="dimensions" name="dimensions" 
                                                   placeholder="e.g., 15x10x8 cm">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="ingredients" class="form-label">Ingredients</label>
                                        <textarea class="form-control" id="ingredients" name="ingredients" rows="3" 
                                                  placeholder="List the product ingredients"></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="flavors" class="form-label">Available Flavors</label>
                                            <input type="text" class="form-control" id="flavors" name="flavors" 
                                                   placeholder="Vanilla, Chocolate, Strawberry (comma separated)">
                                            <div class="form-text">Separate multiple flavors with commas</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sizes" class="form-label">Available Sizes</label>
                                            <input type="text" class="form-control" id="sizes" name="sizes" 
                                                   placeholder="1kg, 2kg, 5kg (comma separated)">
                                            <div class="form-text">Separate multiple sizes with commas</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" 
                                               placeholder="protein, fitness, muscle, gain (comma separated)">
                                        <div class="form-text">Tags help with search and categorization</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_bestseller" name="is_bestseller" value="1">
                                                <label class="form-check-label" for="is_bestseller">Best Seller</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="text-primary mb-0">
                                        <i class="fas fa-images me-2"></i>Product Image
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Recommended size: 800x800px. Leave empty to use default image.</div>
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewProductContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
function resetToAddMode() {
    // Reset form to add mode
    $('#productForm')[0].reset();
    $('#productForm input[name="_method"]').remove();
    $('#addProductModalLabel').html('<i class="fas fa-plus me-2"></i>Add New Product');
    $('#productForm').attr('action', '{{ route("admin.products.store") }}');
    
    // Remove any loading overlays or error messages
    $('#loading-overlay').remove();
    $('.alert').remove();
    
    console.log('Form reset to add mode');
}

// Simplified edit product function - no auth check needed since routes are protected

function viewProduct(id) {
    // Load product details via AJAX
    $('#viewProductModal').modal('show');
    $('#viewProductContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
    
    // Try multiple routes for fetching product data
    const urls = [
        `{{ url('/products') }}/${id}`,
        `{{ url('/test/products') }}/${id}`
    ];
    
    let currentUrl = 0;
    
    function tryFetch() {
        if (currentUrl >= urls.length) {
            $('#viewProductContent').html('<div class="alert alert-danger">Error: Product not found or access denied</div>');
            return;
        }
        
        fetch(urls[currentUrl])
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(product => {
                if (product.error) {
                    throw new Error(product.message);
                }
                
                const features = [];
                if (product.is_featured) features.push('<span class="badge bg-success">Featured</span>');
                if (product.is_bestseller) features.push('<span class="badge bg-danger">Best Seller</span>');
                if (product.is_active) features.push('<span class="badge bg-primary">Active</span>');
                
                // Handle array fields
                const parseArrayField = (field) => {
                    if (!product[field]) return 'N/A';
                    let value = product[field];
                    if (typeof value === 'string') {
                        try {
                            value = JSON.parse(value);
                        } catch (e) {
                            return value;
                        }
                    }
                    if (Array.isArray(value) && value.length > 0) {
                        return value.map(item => `<span class="badge bg-info me-1">${item}</span>`).join('');
                    }
                    return 'N/A';
                };
                
                const flavors = parseArrayField('flavors');
                const sizes = parseArrayField('sizes');
                
                const imageSrc = product.image ? `{{ asset('images') }}/${product.image}` : '{{ asset('images/placeholder.jpg') }}';
                
                $('#viewProductContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <img src="${imageSrc}" class="img-fluid rounded" alt="${product.name}" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                        </div>
                        <div class="col-md-6">
                            <h4>${product.name}</h4>
                            <p class="text-muted">SKU: ${product.sku || 'N/A'}</p>
                            <p><strong>Price:</strong> Rs ${parseFloat(product.price || 0).toFixed(2)}</p>
                            ${product.discount_price ? `<p><strong>Sale Price:</strong> Rs ${parseFloat(product.discount_price).toFixed(2)}</p>` : ''}
                            <p><strong>Stock:</strong> ${product.stock || 0} units</p>
                            <p><strong>Category:</strong> ${product.category ? product.category.name : 'N/A'}</p>
                            <p><strong>Description:</strong> ${product.description || 'No description available'}</p>
                            
                            ${features.length > 0 ? `<h6 class="mt-3">Features:</h6><p>${features.join(' ')}</p>` : ''}
                            
                            <h6 class="mt-3">Available Flavors:</h6>
                            <p>${flavors}</p>
                            
                            <h6 class="mt-3">Available Sizes:</h6>
                            <p>${sizes}</p>
                            
                            ${product.ingredients ? `<h6 class="mt-3">Ingredients:</h6><p class="small">${product.ingredients}</p>` : ''}
                        </div>
                    </div>
                `);
            })
            .catch(error => {
                console.warn(`URL ${urls[currentUrl]} failed:`, error.message);
                currentUrl++;
                tryFetch();
            });
    }
    
    tryFetch();
}

function editProduct(id) {
    console.log(`Edit product called for ID: ${id}`);
    
    // Reset form and modal
    $('#productForm')[0].reset();
    $('#productForm input[name="_method"]').remove();
    
    // Change modal title and form action  
    $('#addProductModalLabel').html('<i class="fas fa-edit me-2"></i>Edit Product');
    $('#productForm').attr('action', `{{ url('/products') }}/${id}/update`);
    
    // Add method field for PUT request
    $('#productForm').append('<input type="hidden" name="_method" value="PUT">');
    
    // Show modal first
    $('#addProductModal').modal('show');
    
    // Add loading indicator to form
    const formContainer = $('#addProductModal .modal-body');
    const loadingHtml = '<div id="loading-overlay" class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><br><small class="text-muted mt-2">Loading product data...</small></div>';
    formContainer.prepend(loadingHtml);
    
    // Try multiple approaches to fetch product data
    const fetchAttempts = [
        // First try the admin route
        {
            url: `{{ url('/products') }}/${id}`,
            method: 'GET',
            description: 'Admin route'
        },
        // Fallback to test route
        {
            url: `{{ url('/test/products') }}/${id}`,
            method: 'GET', 
            description: 'Test route'
        }
    ];
    
    let currentAttempt = 0;
    
    function tryFetchProduct() {
        if (currentAttempt >= fetchAttempts.length) {
            // All attempts failed, show error
            $('#loading-overlay').remove();
            const errorHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Unable to load product data</strong><br>
                    Product ID ${id} could not be found. This could mean:
                    <ul class="mt-2 mb-0">
                        <li>The product has been deleted</li>
                        <li>You don't have permission to edit this product</li>
                        <li>There's a server connection issue</li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            formContainer.prepend(errorHtml);
            return;
        }
        
        const attempt = fetchAttempts[currentAttempt];
        console.log(`Attempt ${currentAttempt + 1}: Trying ${attempt.description} - ${attempt.url}`);
        
        fetch(attempt.url, {
            method: attempt.method,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log(`Response status: ${response.status}`);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(product => {
            console.log('Product data received:', product);
            
            // Remove loading indicator
            $('#loading-overlay').remove();
            
            // Check if we got valid product data
            if (!product || product.error) {
                throw new Error(product?.message || 'Invalid product data received');
            }
            
            // Populate the form with product data
            populateForm(product);
        })
        .catch(error => {
            console.warn(`Attempt ${currentAttempt + 1} failed:`, error.message);
            currentAttempt++;
            tryFetchProduct(); // Try next attempt
        });
    }
    
    function populateForm(product) {
        try {
            // Populate basic fields
            $('#name').val(product.name || '');
            $('#title').val(product.title || product.name || ''); // Use name as fallback for title
            $('#sku').val(product.sku || '');
            $('#description').val(product.description || '');
            $('#price').val(product.price || '');
            $('#discount_price').val(product.discount_price || '');
            $('#category_id').val(product.category_id || '');
            $('#stock').val(product.stock || '');
            $('#min_stock_level').val(product.min_stock_level || '');
            $('#weight').val(product.weight || '');
            $('#dimensions').val(product.dimensions || '');
            $('#ingredients').val(product.ingredients || '');
            
            // Handle array fields (tags, flavors, sizes)
            const arrayFields = ['flavors', 'sizes', 'tags'];
            arrayFields.forEach(field => {
                if (product[field]) {
                    let value = product[field];
                    
                    // If it's a JSON string, parse it
                    if (typeof value === 'string') {
                        try {
                            value = JSON.parse(value);
                        } catch (e) {
                            // If parsing fails, treat as comma-separated string
                            value = value.split(',').map(item => item.trim());
                        }
                    }
                    
                    // Convert array to comma-separated string for input
                    if (Array.isArray(value)) {
                        $(`#${field}`).val(value.join(', '));
                    } else {
                        $(`#${field}`).val(value);
                    }
                }
            });
            
            // Handle checkboxes
            $('#is_featured').prop('checked', Boolean(product.is_featured));
            $('#is_bestseller').prop('checked', Boolean(product.is_bestseller));
            $('#is_active').prop('checked', product.is_active !== false); // Default to true if not specified
            
            console.log('Form populated successfully');
            
            // Show success message
            const successHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Product data loaded successfully! You can now edit the product.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            formContainer.prepend(successHtml);
            
            // Auto-hide success message after 3 seconds
            setTimeout(() => {
                $('.alert-success').fadeOut();
            }, 3000);
            
        } catch (error) {
            console.error('Error populating form:', error);
            const errorHtml = `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Product data loaded but there was an issue populating some fields. 
                    Please verify all data before saving.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            formContainer.prepend(errorHtml);
        }
    }
    
    // Start the fetch process
    tryFetchProduct();
}

function deleteProduct(id) {
    // Use SweetAlert if available, otherwise use confirm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(id);
            }
        });
    } else {
        // Fallback to browser confirm
        if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            performDelete(id);
        }
    }
}

function performDelete(id) {
    // Show loading state
    const deleteBtn = document.querySelector(`button[onclick="deleteProduct(${id})"]`);
    const originalText = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    deleteBtn.disabled = true;
    
    // Send DELETE request
    fetch(`{{ url('/products') }}/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire('Deleted!', data.message || 'Product deleted successfully', 'success')
                    .then(() => window.location.reload());
            } else {
                alert(data.message || 'Product deleted successfully');
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Error deleting product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Show error message
        if (typeof Swal !== 'undefined') {
            Swal.fire('Error!', 'Error deleting product: ' + error.message, 'error');
        } else {
            alert('Error deleting product: ' + error.message);
        }
        
        // Restore button state
        deleteBtn.innerHTML = originalText;
        deleteBtn.disabled = false;
    });
}

// Initialize page functionality when DOM is ready
$(document).ready(function() {
    // Auto-submit form when filters change
    $('#filterForm select').on('change', function() {
        $('#filterForm').submit();
    });
    
    // Reset modal when it's closed
    $('#addProductModal').on('hidden.bs.modal', function () {
        $('#productForm')[0].reset();
        $('#addProductModalLabel').html('<i class="fas fa-plus-circle me-2"></i>Add New Product');
        $('#productForm').attr('action', '{{ route("admin.products.store") }}');
        $('#productForm input[name="_method"]').remove();
        $('#imagePreview').empty();
    });
    
    // Reset form when "Add Product" button is clicked
    $('button[data-bs-target="#addProductModal"]').on('click', function() {
        $('#productForm')[0].reset();
        $('#addProductModalLabel').html('<i class="fas fa-plus-circle me-2"></i>Add New Product');
        $('#productForm').attr('action', '{{ route("admin.products.store") }}');
        $('#productForm input[name="_method"]').remove();
        $('#imagePreview').empty();
    });
    
    // Image preview functionality
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html(`<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`);
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').empty();
        }
    });
    
    // Form validation
    $('#productForm').on('submit', function(e) {
        console.log('Form submission started');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        
        // Check if we're in edit mode
        const methodField = this.querySelector('input[name="_method"]');
        if (methodField) {
            console.log('Method override:', methodField.value);
        }
        
        // Log form data
        const formData = new FormData(this);
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        let isValid = true;
        
        // Check required fields
        if (!$('#name').val().trim()) {
            alert('Product name is required');
            $('#name').focus();
            isValid = false;
        }
        
        if (!$('#title').val().trim()) {
            alert('Product title is required');
            $('#title').focus();
            isValid = false;
        }
        
        if (!$('#price').val() || parseFloat($('#price').val()) <= 0) {
            alert('Valid price is required');
            $('#price').focus();
            isValid = false;
        }
        
        if (!$('#category_id').val()) {
            alert('Category is required');
            $('#category_id').focus();
            isValid = false;
        }
        
        if (!$('#stock').val() || parseInt($('#stock').val()) < 0) {
            alert('Valid stock quantity is required');
            $('#stock').focus();
            isValid = false;
        }
        
        // Validate discount price if provided
        const discountPrice = parseFloat($('#discount_price').val() || 0);
        const regularPrice = parseFloat($('#price').val() || 0);
        
        if (discountPrice > 0 && discountPrice >= regularPrice) {
            alert('Discount price must be less than regular price');
            $('#discount_price').focus();
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...').prop('disabled', true);
        
        // Allow form to submit normally
        // The loading state will be reset by page refresh or modal close
    });
    
    // Auto-calculate and display discount percentage
    $('#price, #discount_price').on('input', function() {
        const price = parseFloat($('#price').val() || 0);
        const discountPrice = parseFloat($('#discount_price').val() || 0);
        
        if (price > 0 && discountPrice > 0 && discountPrice < price) {
            const discountPercent = ((price - discountPrice) / price * 100).toFixed(1);
            $('#discount_price').closest('.mb-3').find('.form-text').remove();
            $('#discount_price').after(`<div class="form-text text-success">Save ${discountPercent}%</div>`);
        } else {
            $('#discount_price').closest('.mb-3').find('.form-text').remove();
        }
    });
});
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);
        
        // Re-enable button after 5 seconds as fallback
        setTimeout(() => {
            submitBtn.html(originalText).prop('disabled', false);
        }, 5000);
        
        return true;
    });
    
    // Add animation to cards
    $('.card').addClass('animate-fade-in');
    
    // Tooltip initialization if using Bootstrap tooltips
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
});
</script>

<!-- SweetAlert2 for better user experience -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Make functions globally accessible by attaching to window object
window.resetToAddMode = function() {
    console.log('Reset to add mode called');
    
    if (typeof $ === 'undefined') {
        console.error('jQuery not loaded');
        return;
    }
    
    try {
        // Reset form
        $('#productForm')[0].reset();
        $('#productForm input[name="_method"]').remove();
        $('#addProductModalLabel').html('<i class="fas fa-plus me-2"></i>Add New Product');
        $('#productForm').attr('action', '{{ route("admin.products.store") }}');
        
        // Remove any loading overlays or alerts
        $('#loading-overlay').remove();
        $('.alert').remove();
        $('#imagePreview').empty();
        
        console.log('Form reset to add mode');
    } catch (error) {
        console.error('Error in resetToAddMode:', error);
    }
};

window.editProduct = function(id) {
    console.log('Edit product called for ID:', id);
    
    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        alert('jQuery is not loaded. Please refresh the page.');
        return;
    }
    
    // Check if modal exists
    if (!document.getElementById('addProductModal')) {
        alert('Product form modal not found. Please refresh the page.');
        return;
    }
    
    try {
        // Reset form and modal
        $('#productForm')[0].reset();
        $('#productForm input[name="_method"]').remove();
        
        // Change modal title and form action
        $('#addProductModalLabel').html('<i class="fas fa-edit me-2"></i>Edit Product');
        $('#productForm').attr('action', `{{ url('/products') }}/${id}/update`);
        
        // Add method field for PUT request
        $('#productForm').append('<input type="hidden" name="_method" value="PUT">');
        
        // Show modal
        $('#addProductModal').modal('show');
        
        // Add loading indicator
        const formContainer = $('#addProductModal .modal-body');
        const loadingHtml = '<div id="loading-overlay" class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><br><small class="text-muted mt-2">Loading product data...</small></div>';
        formContainer.prepend(loadingHtml);
        
        // Fetch product data
        fetch(`{{ url('/products') }}/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(product => {
            // Remove loading indicator
            $('#loading-overlay').remove();
            
            // Populate form fields
            $('#name').val(product.name || '');
            $('#title').val(product.title || product.name || '');
            $('#sku').val(product.sku || '');
            $('#description').val(product.description || '');
            $('#price').val(product.price || '');
            $('#discount_price').val(product.discount_price || '');
            $('#category_id').val(product.category_id || '');
            $('#stock').val(product.stock || '');
            $('#min_stock_level').val(product.min_stock_level || '');
            $('#weight').val(product.weight || '');
            $('#dimensions').val(product.dimensions || '');
            $('#ingredients').val(product.ingredients || '');
            
            // Handle JSON fields
            const jsonFields = ['flavors', 'sizes', 'tags'];
            jsonFields.forEach(field => {
                if (product[field]) {
                    let value = product[field];
                    if (typeof value === 'string') {
                        try {
                            value = JSON.parse(value);
                        } catch (e) {
                            value = value.split(',').map(item => item.trim());
                        }
                    }
                    if (Array.isArray(value)) {
                        $(`#${field}`).val(value.join(', '));
                    } else {
                        $(`#${field}`).val(value);
                    }
                }
            });
            
            // Handle checkboxes
            $('#is_featured').prop('checked', Boolean(product.is_featured));
            $('#is_bestseller').prop('checked', Boolean(product.is_bestseller));
            $('#is_active').prop('checked', product.is_active !== false);
            
            console.log('Product data loaded successfully');
        })
        .catch(error => {
            $('#loading-overlay').remove();
            console.error('Error loading product:', error);
            alert('Error loading product data. Please try again.');
        });
        
    } catch (error) {
        console.error('Error in editProduct:', error);
        alert('Error opening edit form: ' + error.message);
    }
};

window.deleteProduct = function(id) {
    console.log('Delete product called for ID:', id);
    
    // Use SweetAlert2 if available, otherwise browser confirm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(id);
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            performDelete(id);
        }
    }
};

function performDelete(id) {
    // Show loading state on delete button
    const deleteBtn = document.querySelector(`button[onclick*="deleteProduct(${id})"]`);
    if (deleteBtn) {
        const originalHTML = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
    }
    
    // Send DELETE request
    fetch(`{{ url('/products') }}/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Deleted!', data.message || 'Product deleted successfully', 'success')
                    .then(() => window.location.reload());
            } else {
                alert(data.message || 'Product deleted successfully');
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Error deleting product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire('Error!', 'Error deleting product: ' + error.message, 'error');
        } else {
            alert('Error deleting product: ' + error.message);
        }
        
        // Restore button state
        if (deleteBtn) {
            deleteBtn.innerHTML = originalHTML;
            deleteBtn.disabled = false;
        }
    });
}

window.viewProduct = function(id) {
    console.log('View product called for ID:', id);
    
    if (typeof $ === 'undefined') {
        alert('jQuery is not loaded. Please refresh the page.');
        return;
    }
    
    $('#viewProductModal').modal('show');
    $('#viewProductContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...</div>');
    
    fetch(`{{ url('/products') }}/${id}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(product => {
        const content = `
            <div class="row">
                <div class="col-md-4">
                    <img src="${product.image ? '/images/' + product.image : '/images/default-product.jpg'}" 
                         class="img-fluid rounded" alt="${product.name}">
                </div>
                <div class="col-md-8">
                    <h4>${product.name}</h4>
                    <p><strong>SKU:</strong> ${product.sku || 'N/A'}</p>
                    <p><strong>Price:</strong> Rs. ${product.price}</p>
                    ${product.discount_price ? `<p><strong>Discount Price:</strong> Rs. ${product.discount_price}</p>` : ''}
                    <p><strong>Stock:</strong> ${product.stock}</p>
                    <p><strong>Category:</strong> ${product.category ? product.category.name : 'N/A'}</p>
                    <p><strong>Description:</strong> ${product.description || 'No description'}</p>
                </div>
            </div>
        `;
        $('#viewProductContent').html(content);
    })
    .catch(error => {
        console.error('Error:', error);
        $('#viewProductContent').html('<div class="alert alert-danger">Error loading product details</div>');
    });
};

// Test functions on page load
console.log('Product management functions loaded');
console.log('editProduct function:', typeof window.editProduct);
console.log('deleteProduct function:', typeof window.deleteProduct);
console.log('viewProduct function:', typeof window.viewProduct);
</script>

@endsection
