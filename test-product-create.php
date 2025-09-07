<?php

use App\Models\Product;
use App\Models\Category;

$category = Category::first();

if ($category) {
    $product = Product::create([
        'name' => 'Test Protein Powder',
        'title' => 'Test Protein Powder',
        'description' => 'A test protein powder for gym enthusiasts',
        'price' => 2500.00,
        'category_id' => $category->id,
        'stock' => 50,
        'sku' => 'TEST-001',
        'image' => 'default-product.jpg',
        'user_id' => 1,
        'status' => 1,
        'is_active' => true,
        'is_featured' => false,
        'is_bestseller' => false,
        'min_stock_level' => 10
    ]);
    echo 'Product created: ' . $product->name . ' (ID: ' . $product->id . ')' . PHP_EOL;
} else {
    echo 'No categories found' . PHP_EOL;
}
