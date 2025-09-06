<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{

    //user before login


    //user after login
    public function index()
    {
        // Latest products (5 products for better showcase)
        $latestproducts = Product::latest()->take(5)->get();
        
        // Featured categories (top 3 by priority)
        $categories = Category::orderBy('priority')->take(3)->get();
        
        // Best selling products (you can modify this logic based on your sales data)
        $bestsellingproducts = Product::orderBy('created_at', 'desc')->take(4)->get();
        
        // Featured products (products with stock > 10 for example)
        $featuredproducts = Product::where('stock', '>', 10)->take(2)->get();
        
        // Total stats for display
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        
        return view('user.index', compact(
            'latestproducts', 
            'categories', 
            'bestsellingproducts', 
            'featuredproducts',
            'totalProducts',
            'totalCategories', 
            'totalUsers'
        ));
    }


    public function shop()
{
    
    $products = Product::paginate(8);
    $categories = Category::orderBy('priority')->get();
    return view('user.shop', compact('products', 'categories'));
}

    public function productdetails($id)
    {
        $product = Product::find($id);
        return view('user.productdetails', compact('product'));
    }

    public function checkout()
    {


        $user = auth()->user()->id;

       
        $carts = Cart::where('user_id', $user)->where('visible', 1)->get();
        if($carts->count() == 0){
            return redirect()->route('user.cart')->with('error', 'No items in cart');
        }
        
        
        $total = 0;
        $items = 0;

        foreach ($carts as $cart) {
            $items++;
            $total += $cart->product->price * $cart->quantity;
           
            $total = number_format((float)$total, 2, '.', '');
        }

        return view('user.checkout', compact('total', 'items'));
    }

    public function categorysearch($id)
    {
        $products = Product::where('category_id', $id)->paginate(8);
        $categories = Category::orderBy('priority')->get();
        return view('user.shop', compact('products', 'categories'));

    }

public function search(Request $request)
{
    $search = $request->search;
    $products = Product::where('name', 'like', '%' . $search . '%')->paginate(8);
    $categories = Category::orderBy('priority')->get();
    return view('user.shop', compact('products', 'categories'));
}


public function aboutus()
{
    return view('user.aboutus');
}






    //admin

    public function dashboard()
    {
        $users = User::count();
        $products = Product::count();
        $categories = Category::count();
   
        $orders = Order::orderBy('id', 'desc')->take(10)->get();
        $payments = Payment::count();
        return view('admin.index' , compact('users', 'products', 'categories', 'orders', 'payments'));
    }
}
