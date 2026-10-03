<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Relationships
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            // Basic Details
            $table->string('product_name', 255);

            $table->string('slug', 255)
                ->unique();

            $table->string('sku', 100)
                ->unique();
            // Pricing
            $table->decimal('price', 12, 2);

            $table->decimal('discount_price', 12, 2)
                ->nullable();
            // Inventory
            $table->unsignedInteger('stock')
                ->default(0);

            // Description
            $table->text('short_description')
                ->nullable();

            $table->longText('description')
                ->nullable();
            // Product Flags
            $table->boolean('featured')
                ->default(false);

            $table->boolean('status')
                ->default(true)
                ->comment('1 = Active, 0 = Inactive');
            $table->string('meta_title', 255)
                ->nullable();

            $table->text('meta_description')
                ->nullable();

            $table->string('meta_keywords', 500)
                ->nullable();

            $table->string('canonical_url')
                ->nullable();

            $table->boolean('index_status')
                ->default(true)
                ->comment('1 = index, 0 = noindex');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('category_id');
            $table->index('subcategory_id');
            $table->index('brand_id');
            $table->index('status');
            $table->index('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
