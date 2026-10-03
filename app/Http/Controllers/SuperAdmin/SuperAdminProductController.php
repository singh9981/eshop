<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Services\SuperAdmin\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(): View
    {
        $products =
            $this->productService
            ->getAllProducts();
        $module_url = 'super.admin.product.create';

        return view(
            'superadmin.products.list',
            compact('products', 'module_url')
        );
    }

    public function create(): View
    {
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('category_name')->get();

        $brands = Brand::where('status', 1)
            ->orderBy('brand_name')
            ->get();

        $sizes = Size::where('status',1)
            ->orderBy('sort_order')
            ->get();

        return view(
            'superadmin.products.create',
            compact(
                'categories',
                'brands',
                'sizes'
            )
        );
    }

    public function store(
        ProductRequest $request
    ) {

        $this->productService
            ->createProduct(
                $request->validated(),
                $request->file(
                    'images',
                    []
                )
            );

        return redirect()
            ->route(
                'super.admin.product.index'
            )
            ->with(
                'success',
                'Product created successfully.'
            );
    }

    public function edit(
        Product $product
    ): View {

        $product->load([
            'images',
            'sizes',
        ]);

        $categories = Category::whereNull(
            'parent_id'
        )
            ->where('status', 1)
            ->get();

        $subcategories = Category::where(
            'parent_id',
            $product->category_id
        )
            ->where('status', 1)
            ->get();

        $brands = Brand::where(
            'status',
            1
        )
            ->get();

        $sizes = Size::where(
            'status',
            1
        )
            ->get();

        return view(
            'superadmin.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'brands',
                'sizes'
            )
        );
    }

    public function update(
        ProductRequest $request,
        Product $product
    ) {

        $this->productService
            ->updateProduct(
                $product,
                $request->validated(),
                $request->file(
                    'images',
                    []
                )
            );

        return redirect()
            ->route(
                'super.admin.product.index'
            )
            ->with(
                'success',
                'Product updated successfully.'
            );
    }

    public function destroy(
        Product $product
    ) {

        $this->productService
            ->deleteProduct($product);

        return back()
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }

    public function setPrimaryImage(
        Product $product,
        $imageId
    ) {

        $this->productService
            ->setPrimaryImage(
                $product,
                $imageId
            );

        return back()
            ->with(
                'success',
                'Primary image updated.'
            );
    }

    public function deleteImage(
        Product $product,
        $imageId
    ) {

        $this->productService
            ->deleteImage(
                $product,
                $imageId
            );

        return back()
            ->with(
                'success',
                'Image deleted successfully.'
            );
    }
    public function subCategoryajax(Request $request){
        
         $categories = Category::where('parent_id',$request->id)->where('status', 1)->get();
         
            return response()->json($categories);
    }
}
