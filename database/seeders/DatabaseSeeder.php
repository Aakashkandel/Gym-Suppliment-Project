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

       
     
        
    }
}
