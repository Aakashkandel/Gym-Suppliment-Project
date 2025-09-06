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
            $table->text('ingredients')->nullable()->after('description');
            $table->json('flavors')->nullable()->after('ingredients');
            $table->json('sizes')->nullable()->after('flavors');
            $table->json('tags')->nullable()->after('sizes');
            $table->decimal('discount_price', 8, 2)->nullable()->after('price');
            $table->boolean('is_featured')->default(false)->after('discount_price');
            $table->boolean('is_bestseller')->default(false)->after('is_featured');
            $table->json('additional_images')->nullable()->after('image');
            $table->integer('min_stock_level')->default(5)->after('stock');
            $table->decimal('weight', 8, 2)->nullable()->after('min_stock_level');
            $table->string('dimensions')->nullable()->after('weight');
            $table->string('sku')->unique()->nullable()->after('id');
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
            $table->dropColumn([
                'ingredients', 'flavors', 'sizes', 'tags', 'discount_price',
                'is_featured', 'is_bestseller', 'additional_images', 
                'min_stock_level', 'weight', 'dimensions', 'sku'
            ]);
        });
    }
};
