<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user if doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'aakash@admin.com'],
            [
                'name' => 'Aakash Admin',
                'password' => bcrypt('aakash'),
                'role' => 'admin',
            ]
        );

        // Create sample categories if they don't exist
        $categories = [
            [
                'name' => 'Protein Powder',
                'priority' => 1,
                'description' => 'High-quality protein supplements for muscle growth and recovery'
            ],
            [
                'name' => 'Energy Supplements',
                'priority' => 2,
                'description' => 'Pre-workout and energy boosting supplements for enhanced performance'
            ],
            [
                'name' => 'Vitamins',
                'priority' => 3,
                'description' => 'Essential vitamins and minerals for overall health and wellness'
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
            
            // Create sample products for each category if they don't exist
            $products = [
                [
                    'name' => $category->name . ' - Premium Isolate',
                    'title' => 'Premium ' . $category->name,
                    'description' => 'High-quality ' . strtolower($category->name) . ' for optimal results',
                    'price' => rand(1500, 3500),
                    'stock' => rand(20, 100),
                    'image' => 'protein1.jpg',
                    'category_id' => $category->id,
                    'user_id' => $admin->id
                ],
                [
                    'name' => $category->name . ' - Professional Grade',
                    'title' => 'Pro ' . $category->name,
                    'description' => 'Professional grade ' . strtolower($category->name) . ' for serious athletes',
                    'price' => rand(2000, 4000),
                    'stock' => rand(15, 80),
                    'image' => 'protein2.jpg',
                    'category_id' => $category->id,
                    'user_id' => $admin->id
                ]
            ];

            foreach ($products as $productData) {
                Product::firstOrCreate(
                    [
                        'name' => $productData['name'],
                        'category_id' => $category->id
                    ],
                    $productData
                );
            }
        }
    }
}
