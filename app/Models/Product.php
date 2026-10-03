<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'category_id',
        'subcategory_id',
        'brand_id',

        'product_name',
        'slug',
        'sku',

        'price',
        'discount_price',

        'stock',

        'short_description',
        'description',

        'featured',
        'status',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'index_status',
    ];

    protected $casts = [

        'price' => 'decimal:2',

        'discount_price' => 'decimal:2',

        'stock' => 'integer',

        'featured' => 'boolean',

        'status' => 'boolean',

        'index_status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    public function subcategory()
    {
        return $this->belongsTo(
            Category::class,
            'subcategory_id'
        );
    }

    public function brand()
    {
        return $this->belongsTo(
            Brand::class
        );
    }

    public function sizes()
    {
        return $this->belongsToMany(
            Size::class,
            'product_size'
        )
            ->withPivot([
                'sku',
                'price',
                'discount_price',
                'stock',
                'status'
            ])
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(
            ProductImage::class
        )
            ->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(
            ProductImage::class
        )
            ->where('is_primary', 1);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }
}
