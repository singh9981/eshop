<?php

namespace App\Services\SuperAdmin;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /*
    |--------------------------------------------------------------------------
    | Get All Products
    |--------------------------------------------------------------------------
    */

    public function getAllProducts()
    {
        return Product::with([
            'category',
            'subcategory',
            'brand',
            'primaryImage',
            'productSizes.size',
        ])
            ->latest()
            ->paginate(20);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Product By ID
    |--------------------------------------------------------------------------
    */

    public function getProductById(int $id): Product
    {
        return Product::with([
            'category',
            'subcategory',
            'brand',
            'images',
            'productSizes.size',
        ])
            ->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Product
    |--------------------------------------------------------------------------
    */

    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            /*
            |--------------------------------------------------------------------------
            | Get Related Data
            |--------------------------------------------------------------------------
            */

            $sizes = $data['sizes'] ?? [];

            $mainImage = $data['image'] ?? null;

            $galleryImages = $data['gallery_images'] ?? [];

            /*
            |--------------------------------------------------------------------------
            | Remove Non Product Table Fields
            |--------------------------------------------------------------------------
            */

            unset(
                $data['sizes'],
                $data['image'],
                $data['gallery_images']
            );

            /*
            |--------------------------------------------------------------------------
            | Create Product
            |--------------------------------------------------------------------------
            */

            $product = Product::create($data);

            /*
            |--------------------------------------------------------------------------
            | Save Product Sizes
            |--------------------------------------------------------------------------
            */

            if (!empty($sizes)) {
                foreach ($sizes as $size) {
                    $product->productSizes()->create([
                        'size_id' => $size,
                        'sku' => $data['sku'],
                        'price' => $data['price'],
                        'discount_price' => $data['discount_price'] ?? null,
                        'stock' => $data['stock'] ?? 0,
                        'status' => $data['status'] ?? 1,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Save Main Image
            |--------------------------------------------------------------------------
            */

            if ($mainImage) {

                $path = $mainImage->store(
                    'products',
                    'public'
                );

                $product->images()->create([
                    'image' => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Save Gallery Images
            |--------------------------------------------------------------------------
            */

            if (!empty($galleryImages)) {

                foreach ($galleryImages as $key => $image) {

                    $path = $image->store(
                        'products',
                        'public'
                    );

                    $product->images()->create([
                        'image' => $path,
                        'is_primary' => false,
                        'sort_order' => $key + 1,
                    ]);
                }
            }

            return $product->load([
                'images',
                'productSizes.size',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function updateProduct(
        Product $product,
        array $data
    ): Product {

        return DB::transaction(function () use ($product, $data) {

            $sizes = $data['sizes'] ?? [];

            $mainImage = $data['image'] ?? null;

            $galleryImages = $data['gallery_images'] ?? [];

            unset(
                $data['sizes'],
                $data['image'],
                $data['gallery_images']
            );

            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */

            $product->update($data);

            /*
            |--------------------------------------------------------------------------
            | Update Product Sizes
            |--------------------------------------------------------------------------
            */

            if (array_key_exists('sizes', $data) || !empty($sizes)) {

                $existingSizeIds = [];

                foreach ($sizes as $size) {

                    $productSize = $product->productSizes()
                        ->updateOrCreate(
                            [
                                'size_id' => $size['size_id'],
                            ],
                            [
                                'sku' => $size['sku'],
                                'price' => $size['price'],
                                'discount_price' =>
                                $size['discount_price'] ?? null,
                                'stock' => $size['stock'] ?? 0,
                                'status' => $size['status'] ?? 1,
                            ]
                        );

                    $existingSizeIds[] = $productSize->id;
                }

                if (!empty($existingSizeIds)) {

                    $product->productSizes()
                        ->whereNotIn('id', $existingSizeIds)
                        ->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Main Image Update
            |--------------------------------------------------------------------------
            */

            if ($mainImage) {

                /*
                | Make old images non primary
                */

                $product->images()->update([
                    'is_primary' => false,
                ]);

                $path = $mainImage->store(
                    'products',
                    'public'
                );

                $product->images()->create([
                    'image' => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Add Gallery Images
            |--------------------------------------------------------------------------
            */

            if (!empty($galleryImages)) {

                $currentCount = $product->images()->count();

                foreach ($galleryImages as $key => $image) {

                    $path = $image->store(
                        'products',
                        'public'
                    );

                    $product->images()->create([
                        'image' => $path,
                        'is_primary' => false,
                        'sort_order' =>
                        $currentCount + $key + 1,
                    ]);
                }
            }

            return $product->fresh([
                'images',
                'productSizes.size',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Set Primary Image
    |--------------------------------------------------------------------------
    */

    public function setPrimaryImage(
        Product $product,
        int $imageId
    ): void {

        DB::transaction(function () use ($product, $imageId) {

            $image = $product->images()
                ->where('id', $imageId)
                ->firstOrFail();

            $product->images()->update([
                'is_primary' => false,
            ]);

            $image->update([
                'is_primary' => true,
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Product Image
    |--------------------------------------------------------------------------
    */

    public function deleteImage(
        Product $product,
        int $imageId
    ): void {

        DB::transaction(function () use ($product, $imageId) {

            $image = $product->images()
                ->where('id', $imageId)
                ->firstOrFail();

            $wasPrimary = $image->is_primary;

            if (
                $image->image &&
                Storage::disk('public')->exists($image->image)
            ) {
                Storage::disk('public')->delete($image->image);
            }

            $image->delete();

            /*
            |--------------------------------------------------------------------------
            | Set Next Image Primary
            |--------------------------------------------------------------------------
            */

            if ($wasPrimary) {

                $nextImage = $product->images()
                    ->orderBy('sort_order')
                    ->first();

                if ($nextImage) {

                    $nextImage->update([
                        'is_primary' => true,
                    ]);
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function deleteProduct(Product $product): bool
    {
        return DB::transaction(function () use ($product) {

            /*
            |--------------------------------------------------------------------------
            | Delete Physical Images
            |--------------------------------------------------------------------------
            */

            foreach ($product->images as $image) {

                if (
                    $image->image &&
                    Storage::disk('public')->exists($image->image)
                ) {
                    Storage::disk('public')->delete($image->image);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Delete Product Sizes
            |--------------------------------------------------------------------------
            */

            $product->productSizes()->delete();

            /*
            |--------------------------------------------------------------------------
            | Delete Product Images
            |--------------------------------------------------------------------------
            */

            $product->images()->delete();

            /*
            |--------------------------------------------------------------------------
            | Delete Product
            |--------------------------------------------------------------------------
            */

            return $product->delete();
        });
    }
}
