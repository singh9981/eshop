<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        $productId = $product instanceof Product
            ? $product->id
            : $product;

        return [

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'product_name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'products',
                    'slug'
                )->ignore($productId),
            ],

            'sku' => [
                'required',
                'string',
                'max:100',

                Rule::unique(
                    'products',
                    'sku'
                )->ignore($productId),
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'featured' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                'boolean',
            ],
            'image' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            // Gallery images array
            'gallery_images' => [
                'nullable',
                'array',
            ],

            'gallery_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'sizes' => [
                'nullable',
                'array',
            ],

            'sizes.*' => [
                'exists:sizes,id',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:500',
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'index_status' => [
                'required',
                'boolean',
            ],
        ];
    }
}
