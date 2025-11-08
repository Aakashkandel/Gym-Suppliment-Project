<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Apply filters
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        if ($request->has('bestseller') && $request->bestseller !== '') {
            $query->where('is_bestseller', $request->bestseller);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('priority')->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'flavors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'tags' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean'
        ]);

        // Generate SKU if not provided
        if (!$request->has('sku') || !$request->sku) {
            $data['sku'] = 'PRD-' . strtoupper(Str::random(8));
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Handle additional images
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->extension();
                $image->move(public_path('images/products'), $imageName);
                $additionalImages[] = 'images/products/' . $imageName;
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        // Handle JSON fields
        $data['flavors'] = $request->flavors ? json_encode($request->flavors) : null;
        $data['sizes'] = $request->sizes ? json_encode($request->sizes) : null;
        $data['tags'] = $request->tags ? json_encode($request->tags) : null;

        // Set boolean fields
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_bestseller'] = $request->boolean('is_bestseller', false);
        $data['status'] = $data['is_active'];

        // Set user_id
        $data['user_id'] = Auth::id();

        Product::create($data);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->orderBy('priority')->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'flavors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'tags' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean'
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            // Delete old additional images
            if ($product->additional_images) {
                $oldImages = json_decode($product->additional_images, true);
                foreach ($oldImages as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }

            $additionalImages = [];
            foreach ($request->file('additional_images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->extension();
                $image->move(public_path('images/products'), $imageName);
                $additionalImages[] = 'images/products/' . $imageName;
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        // Handle JSON fields
        $data['flavors'] = $request->flavors ? json_encode($request->flavors) : null;
        $data['sizes'] = $request->sizes ? json_encode($request->sizes) : null;
        $data['tags'] = $request->tags ? json_encode($request->tags) : null;

        // Set boolean fields
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_bestseller'] = $request->boolean('is_bestseller', false);
        $data['status'] = $data['is_active'];

        $product->update($data);

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete main image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Delete additional images
        if ($product->additional_images) {
            $additionalImages = json_decode($product->additional_images, true);
            foreach ($additionalImages as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }

    // Enhanced features
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->status = $product->is_active;
        $product->save();

        $status = $product->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Product {$status} successfully");
    }

    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'marked as featured' : 'unmarked as featured';
        return redirect()->back()->with('success', "Product {$status} successfully");
    }

    public function toggleBestseller($id)
    {
        $product = Product::findOrFail($id);
        $product->is_bestseller = !$product->is_bestseller;
        $product->save();

        $status = $product->is_bestseller ? 'marked as bestseller' : 'unmarked as bestseller';
        return redirect()->back()->with('success', "Product {$status} successfully");
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;

        if ($request->has('min_stock_level')) {
            $product->min_stock_level = $request->min_stock_level;
        }

        $product->save();

        return redirect()->back()->with('success', 'Stock updated successfully');
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'action' => 'required|in:activate,deactivate,feature,unfeature,bestseller,unbestseller,delete'
        ]);

        $products = Product::whereIn('id', $request->products);

        switch ($request->action) {
            case 'activate':
                $products->update(['is_active' => true, 'status' => true]);
                $message = 'Products activated successfully';
                break;
            case 'deactivate':
                $products->update(['is_active' => false, 'status' => false]);
                $message = 'Products deactivated successfully';
                break;
            case 'feature':
                $products->update(['is_featured' => true]);
                $message = 'Products marked as featured successfully';
                break;
            case 'unfeature':
                $products->update(['is_featured' => false]);
                $message = 'Products unmarked as featured successfully';
                break;
            case 'bestseller':
                $products->update(['is_bestseller' => true]);
                $message = 'Products marked as bestseller successfully';
                break;
            case 'unbestseller':
                $products->update(['is_bestseller' => false]);
                $message = 'Products unmarked as bestseller successfully';
                break;
            case 'delete':
                // Delete associated images
                foreach ($products->get() as $product) {
                    if ($product->image && file_exists(public_path($product->image))) {
                        unlink(public_path($product->image));
                    }
                    if ($product->additional_images) {
                        $additionalImages = json_decode($product->additional_images, true);
                        foreach ($additionalImages as $image) {
                            if (file_exists(public_path($image))) {
                                unlink(public_path($image));
                            }
                        }
                    }
                }
                $products->delete();
                $message = 'Products deleted successfully';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
