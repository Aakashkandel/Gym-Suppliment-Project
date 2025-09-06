<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add missing columns for enhanced products
            $table->decimal('discount_price', 10, 2)->nullable()->after('price');
            $table->string('sku')->unique()->nullable()->after('stock');
            $table->string('weight')->nullable()->after('sku');
            $table->string('dimensions')->nullable()->after('weight');
            $table->integer('min_stock_level')->default(10)->after('dimensions');
            $table->text('ingredients')->nullable()->after('min_stock_level');
            $table->json('flavors')->nullable()->after('ingredients');
            $table->json('sizes')->nullable()->after('flavors');
            $table->json('tags')->nullable()->after('sizes');
            $table->json('additional_images')->nullable()->after('tags');
            $table->boolean('is_active')->default(true)->after('additional_images');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->boolean('is_bestseller')->default(false)->after('is_featured');
            
            // Modify existing columns
            $table->decimal('price', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn([
                'discount_price',
                'sku',
                'weight',
                'dimensions',
                'min_stock_level',
                'ingredients',
                'flavors',
                'sizes',
                'tags',
                'additional_images',
                'is_active',
                'is_featured',
                'is_bestseller'
            ]);
        });
    }
};
