<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $productCount = DB::table('products')->count();
    echo "Total products in database: $productCount\n";
    
    if ($productCount > 0) {
        $firstProduct = DB::table('products')->first();
        echo "First product: {$firstProduct->name} (ID: {$firstProduct->id})\n";
    } else {
        echo "No products found in database\n";
        
        // Create a sample category if needed
        $categoryCount = DB::table('categories')->count();
        if ($categoryCount == 0) {
            DB::table('categories')->insert([
                'name' => 'Supplements',
                'description' => 'Health and fitness supplements',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "Created sample category\n";
        }
        
        $categoryId = DB::table('categories')->first()->id;
        
        // Create a sample product
        DB::table('products')->insert([
            'name' => 'Sample Protein Powder',
            'title' => 'Sample Protein Powder',
            'description' => 'High quality whey protein powder for muscle building',
            'price' => 29.99,
            'stock' => 100,
            'category_id' => $categoryId,
            'user_id' => 1,
            'status' => 1,
            'image' => 'default-product.jpg',
            'sku' => 'PRD-000001',
            'is_active' => true,
            'is_featured' => false,
            'is_bestseller' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "Created sample product\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
