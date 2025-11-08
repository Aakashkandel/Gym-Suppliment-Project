<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'isadmin', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Category management
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    // Product management
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::get('/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');

    // Order management
    Route::get('/order', [AdminController::class, 'index'])->name('admin.order');
    Route::get('/order/accept/{id}', [AdminController::class, 'acceptorder'])->name('admin.order.accept');
    Route::get('/order/reject/{id}', [AdminController::class, 'rejectorder'])->name('admin.order.reject');
    Route::post('/order/status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
    Route::post('/order/payment-status/{id}', [AdminController::class, 'updatePaymentStatus'])->name('admin.order.payment-status');
    Route::get('/order/invoice/{id}', [AdminController::class, 'downloadInvoice'])->name('admin.order.invoice');

    // Payment management
    Route::get('/payment', [AdminController::class, 'payment'])->name('admin.payment');

    // User management
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');

    // Customer management
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers.index');
    Route::get('/customers/create', [AdminController::class, 'createCustomer'])->name('admin.customers.create');
    Route::post('/customers', [AdminController::class, 'storeCustomer'])->name('admin.customers.store');
    Route::get('/customers/{id}', [AdminController::class, 'showCustomer'])->name('admin.customers.show');
    Route::get('/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('admin.customers.edit');
    Route::put('/customers/{id}', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::delete('/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');
    Route::post('/customers/{id}/send-email', [AdminController::class, 'sendCustomerEmail'])->name('admin.customers.email');
    Route::post('/customers/{id}/notes', [AdminController::class, 'addCustomerNote'])->name('admin.customers.notes');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/analytics/sales', [AdminController::class, 'salesAnalytics'])->name('admin.analytics.sales');

    // Stock management
    Route::get('/stock', [AdminController::class, 'stockManagement'])->name('admin.stock.index');
    Route::post('/stock/update/{id}', [AdminController::class, 'updateStock'])->name('admin.stock.update');

    // Enhanced Product Management
    Route::get('/products/enhanced', [AdminController::class, 'enhancedProducts'])->name('admin.products.enhanced');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}', [AdminController::class, 'showProduct'])->name('admin.products.show');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::put('/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.products.update.post');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    // Test API endpoint
    Route::get('/api/test', [AdminController::class, 'testApi'])->name('admin.api.test');

    // Invoice Generation
    Route::get('/orders/{id}/invoice', [AdminController::class, 'generateInvoice'])->name('admin.orders.invoice');
});

// Temporary public routes for testing (remove in production)
Route::get('/test/products/{id}', [AdminController::class, 'showProduct'])->name('test.products.show');
Route::get('/test/products-list', function() {
    return response()->json(\App\Models\Product::select('id', 'name', 'sku')->take(10)->get());
});
Route::get('/debug/products', function() {
    $products = \App\Models\Product::with('category')->select('id', 'name', 'sku', 'price', 'category_id')->get();
    return response()->json([
        'count' => $products->count(),
        'products' => $products
    ]);
});


Route::middleware(['auth', 'isuser', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //cart routes
    Route::get('/productdetails/{id}', [PageController::class, 'productdetails'])->name('user.productdetails');
    Route::post('productdetails/store', [CartController::class, 'store'])->name('productdetails.store');


    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
    Route::get('/cart/destroy/{id}', [CartController::class, 'destroy'])->name('user.cart.destroy');
    Route::post('cart/update/{id}', [CartController::class, 'update'])->name('user.cart.update');


    Route::get('/checkout', [PageController::class, 'checkout'])->name('user.checkout');

    //order routes
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

    //payment routes
    Route::get('/payment/esewa/success', [PaymentController::class, 'esewasuccess'])->name('esewa.success');
    Route::get('/payment/esewa/fail', [PaymentController::class, 'esewafail'])->name('esewa.fail');
    Route::post('/payment/cod', [PaymentController::class, 'codPayment'])->name('payment.cod');

    //order history
    Route::get('/orderhistory',[OrderController::class,'history'])->name('user.orderhistory');
    Route::get('/ordercancel/{id}',[OrderController::class,'cancleorder'])->name('user.ordercancel');
    Route::get('/orderproduct/{id}',[OrderController::class,'orderproduct'])->name('user.orderproduct');
    Route::get('/deleteorder/{id}',[OrderController::class,'deleteorder'])->name('user.deleteorder');


});
Route::get('/categorysearch/{id}', [PageController::class, 'categorysearch'])->name('user.categorysearch');
Route::get('/search', [PageController::class, 'search'])->name('user.search');

Route::get('/aboutus',[PageController::class,'aboutus'])->name('user.aboutus');



//visitor routes and able to access by all
Route::get('/', [PageController::class, 'index'])->name('user.index');
Route::get('/shop', [PageController::class, 'shop'])->name('user.shop');









require __DIR__ . '/auth.php';
