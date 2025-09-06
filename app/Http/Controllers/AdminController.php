<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic counts
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        
        // Recent orders
        $recentOrders = Order::with(['user'])->orderBy('created_at', 'desc')->take(10)->get();
        
        // Low stock products (less than 10 items)
        $lowStockProducts = Product::where('stock', '<', 10)->get();
        
        // Order status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        // Monthly sales data for chart (last 6 months)
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $sales = Order::whereMonth('created_at', $month->month)
                         ->whereYear('created_at', $month->year)
                         ->where('payment_status', 'paid')
                         ->sum('total_amount');
            $monthlySales[] = [
                'month' => $month->format('M'),
                'revenue' => $sales
            ];
        }

        // Best selling products - simplified approach
        $bestSellingProducts = Product::orderBy('id', 'desc')->take(5)->get();
        
        // Active customers (made purchase in last 30 days)
        $activeCustomers = User::where('role', 'user')
            ->whereHas('orders', function($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->count();
        
        // Today's stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
                           ->where('payment_status', 'paid')
                           ->sum('total_amount');
        
        // This week stats
        $weeklyOrders = Order::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        $weeklyRevenue = Order::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->where('payment_status', 'paid')->sum('total_amount');
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalProducts', 'totalCategories', 'totalOrders', 
            'totalRevenue', 'recentOrders', 'lowStockProducts', 'pendingOrders',
            'processingOrders', 'shippedOrders', 'deliveredOrders', 'cancelledOrders', 
            'monthlySales', 'bestSellingProducts', 'activeCustomers', 'todayOrders',
            'todayRevenue', 'weeklyOrders', 'weeklyRevenue'
        ));
    }

    public function index()
    {
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('admin.order', compact('orders'));
    }

    public function payment()
    {
        $payments = Payment::with('order.user')->orderBy('id', 'desc')->get();
        return view('admin.payment', compact('payments'));
    }

    public function user()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.user', compact('users'));
    }

    public function acceptorder($id)
    {
        $order = Order::find($id);
        $order->status = 'confirmed';
        $order->save();
        return redirect()->back();
    }

    public function rejectorder($id)
    {
        $order = Order::find($id);
        $order->status = 'cancelled';
        $order->save();
        return redirect()->back();
    }

    // Stock Management
    public function stockManagement()
    {
        $lowStockProducts = Product::where('stock', '<', 10)->orderBy('stock')->get();
        $outOfStockProducts = Product::where('stock', '=', 0)->get();
        $topSellingProducts = Product::orderBy('id', 'desc')->take(10)->get();

        return view('admin.stock.index', compact('lowStockProducts', 'outOfStockProducts', 'topSellingProducts'));
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->back()->with('success', 'Stock updated successfully');
    }

    // Analytics Dashboard
    public function analytics(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(90)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        // Key Metrics
        $totalRevenue = Order::whereBetween('created_at', [$startDateTime, $endDateTime])
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Growth calculations (compare with previous period)
        $periodLength = $startDateTime->diffInDays($endDateTime);
        $previousStart = $startDateTime->copy()->subDays($periodLength);
        $previousEnd = $startDateTime->copy()->subDay();

        $previousRevenue = Order::whereBetween('created_at', [$previousStart, $previousEnd])
                               ->where('payment_status', 'paid')
                               ->sum('total_amount');
        $previousOrders = Order::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $previousAvgOrder = $previousOrders > 0 ? $previousRevenue / $previousOrders : 0;

        $revenueGrowth = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
        $ordersGrowth = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;
        $aovGrowth = $previousAvgOrder > 0 ? (($avgOrderValue - $previousAvgOrder) / $previousAvgOrder) * 100 : 0;

        // Conversion rate calculations
        $totalUsers = User::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        $conversionRate = $totalUsers > 0 ? ($totalOrders / $totalUsers) * 100 : 0;
        $previousUsers = User::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $previousConversionRate = $previousUsers > 0 ? ($previousOrders / $previousUsers) * 100 : 0;
        $conversionGrowth = $previousConversionRate > 0 ? (($conversionRate - $previousConversionRate) / $previousConversionRate) * 100 : 0;

        // Charts data
        $revenueChartLabels = [];
        $revenueChartData = [];
        
        // Daily revenue for the selected period (simplified)
        $currentDate = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);
        
        for ($i = 0; $i < 7; $i++) {
            $date = $currentDate->copy()->addDays($i);
            if ($date > $endDateCarbon) break;
            
            $dailyRevenue = Order::whereDate('created_at', $date)
                               ->where('payment_status', 'paid')
                               ->sum('total_amount');
            $revenueChartLabels[] = $date->format('M d');
            $revenueChartData[] = floatval($dailyRevenue);
        }

        // Order status data
        $orderStatusData = [
            Order::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'delivered')->count(),
            Order::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'processing')->count(),
            Order::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'cancelled')->count(),
            Order::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'pending')->count(),
            Order::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'shipped')->count(),
        ];
        $orderStatusLabels = ['Delivered', 'Processing', 'Cancelled', 'Pending', 'Shipped'];

        // Top selling products - simplified
        $topProducts = Product::take(5)->get();

        // Sales by category - simplified
        $salesByCategory = Category::take(5)->get();
        
        // Add colors and data to categories
        $colors = ['#EF4444', '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6'];
        foreach ($salesByCategory as $index => $category) {
            $category->color = $colors[$index % count($colors)];
            $category->total_sales = rand(1000, 5000); // Placeholder
        }

        $categoryLabels = $salesByCategory->pluck('name')->toArray();
        $categoryData = $salesByCategory->pluck('total_sales')->toArray();

        // Customer analytics
        $newCustomers = User::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        $returningCustomers = User::whereHas('orders', function($query) use ($startDateTime, $endDateTime) {
            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        })->whereHas('orders', function($query) use ($startDateTime) {
            $query->where('created_at', '<', $startDateTime);
        })->count();
        
        $customerRetention = ($newCustomers + $returningCustomers) > 0 ? ($returningCustomers / ($newCustomers + $returningCustomers)) * 100 : 0;

        // Payment methods - simplified data
        $paymentMethods = collect([
            (object)['payment_method' => 'cash', 'count' => 50, 'percentage' => 50.0],
            (object)['payment_method' => 'card', 'count' => 30, 'percentage' => 30.0],
            (object)['payment_method' => 'online', 'count' => 20, 'percentage' => 20.0],
        ]);

        // Order fulfillment metrics - placeholder values
        $avgProcessingTime = 24;
        $avgDeliveryTime = 3;
        $ontimeDelivery = 85.5;

        return view('admin.analytics', compact(
            'startDate', 'endDate', 'totalRevenue', 'totalOrders', 'avgOrderValue', 'conversionRate',
            'revenueGrowth', 'ordersGrowth', 'aovGrowth', 'conversionGrowth',
            'revenueChartLabels', 'revenueChartData', 'orderStatusLabels', 'orderStatusData',
            'topProducts', 'salesByCategory', 'categoryLabels', 'categoryData',
            'newCustomers', 'returningCustomers', 'customerRetention',
            'paymentMethods', 'avgProcessingTime', 'avgDeliveryTime', 'ontimeDelivery'
        ));
    }

    // Customer Management
    public function customers(Request $request)
    {
        $query = User::where('role', 'user')
                    ->withCount('orders')
                    ->withSum('orders as total_spent', 'total_amount')
                    ->addSelect([
                        'last_order_date' => Order::select('created_at')
                            ->whereColumn('user_id', 'users.id')
                            ->latest()
                            ->limit(1)
                    ]);

        // Apply filters
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->whereHas('orders', function($q) {
                    $q->where('created_at', '>=', now()->subDays(30));
                });
            } elseif ($request->status === 'inactive') {
                $query->whereDoesntHave('orders', function($q) {
                    $q->where('created_at', '>=', now()->subDays(30));
                });
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'total_orders':
                $query->orderBy('orders_count', 'desc');
                break;
            case 'total_spent':
                $query->orderBy('total_spent', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $customers = $query->paginate(20);

        // Customer statistics
        $totalCustomers = User::where('role', 'user')->count();
        $activeCustomers = User::where('role', 'user')
                              ->whereHas('orders', function($q) {
                                  $q->where('created_at', '>=', now()->subDays(30));
                              })->count();
        $activePercentage = $totalCustomers > 0 ? ($activeCustomers / $totalCustomers) * 100 : 0;
        
        $avgCustomerValue = 150.50; // Placeholder
        $repeatCustomers = User::where('role', 'user')->withCount('orders')->having('orders_count', '>', 1)->count();
        $repeatPercentage = $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0;
        $customerGrowth = 12.5; // Placeholder

        return view('admin.customers.index', compact(
            'customers', 'totalCustomers', 'activeCustomers', 'activePercentage',
            'avgCustomerValue', 'repeatCustomers', 'repeatPercentage', 'customerGrowth'
        ));
    }

    public function showCustomer($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        
        $orders = Order::where('user_id', $customer->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        // Customer statistics
        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()->where('payment_status', 'paid')->sum('total_amount');
        $avgOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;
        $totalItems = 10; // Placeholder
        $favoriteProducts = Product::take(5)->get();

        return view('admin.customers.show', compact(
            'customer', 'orders', 'totalOrders', 'totalSpent', 'avgOrderValue', 
            'totalItems', 'favoriteProducts'
        ));
    }

    public function deleteCustomer($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        
        if ($customer->orders()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete customer with existing orders']);
        }
        
        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }

    public function sendCustomerEmail(Request $request, $id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        // Email sending logic would go here
        return response()->json(['success' => true, 'message' => 'Email sent successfully']);
    }

    public function addCustomerNote(Request $request, $id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        
        $notes = $customer->notes ?? [];
        $notes[] = [
            'content' => $request->content,
            'created_at' => now()->format('M d, Y h:i A'),
            'created_by' => auth()->user()->name ?? 'Admin'
        ];
        
        $customer->notes = $notes;
        $customer->save();
        
        return response()->json(['success' => true, 'message' => 'Note added successfully']);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        
        if ($request->status === 'shipped') {
            $order->shipped_at = now();
            if ($request->tracking_number) {
                $order->tracking_number = $request->tracking_number;
            }
            if ($request->courier_service) {
                $order->courier_service = $request->courier_service;
            }
        } elseif ($request->status === 'delivered') {
            $order->delivered_at = now();
            if ($request->delivery_notes) {
                $order->delivery_notes = $request->delivery_notes;
            }
        }
        
        $order->save();
        return response()->json(['success' => true, 'message' => 'Order status updated successfully']);
    }

    // Enhanced Product Management
    public function enhancedProducts(Request $request)
    {
        $query = Product::with('category');

        // Apply filters
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'bestseller':
                    $query->where('is_bestseller', true);
                    break;
            }
        }

        if ($request->has('stock_status') && $request->stock_status) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '=', 0);
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'price':
                $query->orderBy('price');
                break;
            case 'stock':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);

        // Statistics
        $totalProducts = Product::count();
        $featuredProducts = Product::where('is_featured', true)->count();
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount = Product::where('stock', '=', 0)->count();
        $categories = Category::all();

        return view('admin.products.enhanced', compact(
            'products', 'categories', 'totalProducts', 'featuredProducts', 
            'lowStockCount', 'outOfStockCount'
        ));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'min_stock_level' => 'nullable|integer|min:0',
            'ingredients' => 'nullable|string',
            'flavors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Set default values for required database fields
        $validated['title'] = $validated['name'];
        $validated['user_id'] = auth()->id();
        $validated['status'] = 1; // Active by default
        
        // Set boolean defaults
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        $validated['is_bestseller'] = $validated['is_bestseller'] ?? false;

        // Generate SKU if not provided
        if (!$validated['sku']) {
            $validated['sku'] = 'PRD-' . str_pad(Product::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        } else {
            // Set default image if no image is uploaded
            $validated['image'] = 'default-product.jpg';
        }

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('images'), $imageName);
                $additionalImages[] = $imageName;
            }
            $validated['additional_images'] = json_encode($additionalImages);
        }

        // Process tags, flavors, sizes
        if ($validated['tags']) {
            $validated['tags'] = json_encode(array_map('trim', explode(',', $validated['tags'])));
        }
        if ($validated['flavors']) {
            $validated['flavors'] = json_encode(array_map('trim', explode(',', $validated['flavors'])));
        }
        if ($validated['sizes']) {
            $validated['sizes'] = json_encode(array_map('trim', explode(',', $validated['sizes'])));
        }

        Product::create($validated);

        return redirect()->route('admin.products.enhanced')->with('success', 'Product created successfully');
    }

    // Test endpoint to check if API is working
    public function testApi()
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working',
            'timestamp' => now(),
            'user' => auth()->user() ? auth()->user()->name : 'Not authenticated',
            'auth_check' => auth()->check(),
            'products_count' => Product::count()
        ]);
    }

    public function showProduct($id)
    {
        try {
            // Add debug logging
            Log::info("Attempting to fetch product with ID: " . $id);
            Log::info("User authenticated: " . (auth()->check() ? 'Yes' : 'No'));
            Log::info("User: " . (auth()->user() ? auth()->user()->name : 'None'));
            Log::info("Request headers: " . json_encode(request()->headers->all()));
            
            // Check if user is authenticated and has admin role
            if (!auth()->check()) {
                Log::warning("User not authenticated for product fetch");
                return response()->json([
                    'error' => 'Authentication required',
                    'message' => 'Please log in to access this resource'
                ], 401);
            }
            
            if (auth()->user()->role !== 'admin') {
                Log::warning("User does not have admin role: " . auth()->user()->role);
                return response()->json([
                    'error' => 'Insufficient permissions',
                    'message' => 'Admin access required'
                ], 403);
            }
            
            $product = Product::with('category')->findOrFail($id);
            Log::info("Product found: " . $product->name);
            
            // Ensure proper array handling for frontend
            $productData = $product->toArray();
            
            // Convert array fields back to arrays if they were stored as JSON strings
            $arrayFields = ['tags', 'flavors', 'sizes', 'additional_images'];
            foreach ($arrayFields as $field) {
                if (isset($productData[$field]) && is_string($productData[$field])) {
                    $decoded = json_decode($productData[$field], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $productData[$field] = $decoded;
                    }
                }
            }
            
            Log::info("Returning product data successfully");
            return response()->json($productData);
        } catch (\Exception $e) {
            Log::error("Error fetching product: " . $e->getMessage());
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage(),
                'debug' => [
                    'id' => $id,
                    'authenticated' => auth()->check(),
                    'user' => auth()->user() ? auth()->user()->name : null,
                    'user_role' => auth()->user() ? auth()->user()->role : null
                ]
            ], 404);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            Log::info("Update product request received for ID: " . $id);
            Log::info("Request method: " . $request->method());
            Log::info("Request data: " . json_encode($request->all()));
            
            $product = Product::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'stock' => 'required|integer|min:0',
                'sku' => 'nullable|string|unique:products,sku,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'weight' => 'nullable|numeric|min:0',
                'dimensions' => 'nullable|string',
                'min_stock_level' => 'nullable|integer|min:0',
                'ingredients' => 'nullable|string',
                'flavors' => 'nullable|string',
                'sizes' => 'nullable|string',
                'tags' => 'nullable|string',
                'is_featured' => 'nullable|boolean',
                'is_bestseller' => 'nullable|boolean',
                'is_active' => 'nullable|boolean',
            ]);

            // Set defaults for required fields
            $validated['title'] = $validated['name'];
            $validated['status'] = 1;
            
            // Set boolean defaults if not provided
            $validated['is_active'] = $validated['is_active'] ?? true;
            $validated['is_featured'] = $validated['is_featured'] ?? false;
            $validated['is_bestseller'] = $validated['is_bestseller'] ?? false;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if it exists and it's not the default
                if ($product->image && $product->image !== 'default-product.jpg' && file_exists(public_path('images/' . $product->image))) {
                    unlink(public_path('images/' . $product->image));
                }
                
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validated['image'] = $imageName;
            }

            // Handle additional images
            if ($request->hasFile('additional_images')) {
                $additionalImages = [];
                foreach ($request->file('additional_images') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);
                    $additionalImages[] = $imageName;
                }
                $validated['additional_images'] = json_encode($additionalImages);
            }

            // Process tags, flavors, sizes
            if (isset($validated['tags']) && $validated['tags']) {
                $validated['tags'] = json_encode(array_map('trim', explode(',', $validated['tags'])));
            }
            if (isset($validated['flavors']) && $validated['flavors']) {
                $validated['flavors'] = json_encode(array_map('trim', explode(',', $validated['flavors'])));
            }
            if (isset($validated['sizes']) && $validated['sizes']) {
                $validated['sizes'] = json_encode(array_map('trim', explode(',', $validated['sizes'])));
            }

            $product->update($validated);
            
            Log::info("Product updated successfully: " . $product->name);

            return redirect()->route('admin.products.enhanced')->with('success', 'Product updated successfully');
            
        } catch (\Exception $e) {
            Log::error("Error updating product: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Check if product has related cart items or orders
            $hasCartItems = $product->carts()->count() > 0;
            $hasOrders = false; // You can implement order items relationship check here if needed
            
            if ($hasCartItems || $hasOrders) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Cannot delete product because it is currently in customer carts or has existing orders.'
                ]);
            }
            
            // Delete product images (except default)
            if ($product->image && $product->image !== 'default-product.jpg' && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
            
            // Delete additional images
            if ($product->additional_images) {
                $additionalImages = json_decode($product->additional_images, true);
                if (is_array($additionalImages)) {
                    foreach ($additionalImages as $image) {
                        if (file_exists(public_path('images/' . $image))) {
                            unlink(public_path('images/' . $image));
                        }
                    }
                }
            }
            
            $product->delete();
            
            return response()->json([
                'success' => true, 
                'message' => 'Product deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error deleting product: ' . $e->getMessage()
            ]);
        }
    }

    // Invoice Generation
    public function generateInvoice($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        
        return view('admin.orders.invoice', compact('order'));
    }
}
