@extends('layouts.superadmin.app')
@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Products</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the following errors:</strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card stretch stretch-full">
                            <form action="{{ route('super.admin.product.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">

                                        {{-- Product Name --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Product Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="product_name" id="product_name"
                                                    value="{{ old('product_name') }}"
                                                    class="form-control @error('product_name') is-invalid @enderror"
                                                    placeholder="Product Name">

                                                @error('product_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Slug --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Slug
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="slug" id="slug"
                                                    value="{{ old('slug') }}"
                                                    class="form-control @error('slug') is-invalid @enderror"
                                                    placeholder="product-slug">

                                                @error('slug')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Category --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Category
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="category_id" id="category_id"
                                                    class="form-control @error('category_id') is-invalid @enderror">
                                                    <option value="">
                                                        Select Category
                                                    </option>

                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Sub Category --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Sub Category
                                                </label>

                                                <select name="subcategory_id" id="subcategory_id"
                                                    class="form-control @error('subcategory_id') is-invalid @enderror">
                                                    <option value="">
                                                        Select Sub Category
                                                    </option>

                                                    @foreach ($subCategories ?? [] as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @selected(old('subcategory_id') == $subCategory->id)>
                                                            {{ $subCategory->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('subcategory_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Brand --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Brand
                                                </label>

                                                <select name="brand_id"
                                                    class="form-control @error('brand_id') is-invalid @enderror">
                                                    <option value="">
                                                        Select Brand
                                                    </option>

                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                                            {{ $brand->brand_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('brand_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- SKU --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    SKU
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="sku" value="{{ old('sku') }}"
                                                    class="form-control @error('sku') is-invalid @enderror"
                                                    placeholder="SKU-001">

                                                @error('sku')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Price --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Price
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" name="price" step="0.01" min="0"
                                                    value="{{ old('price') }}"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    placeholder="0.00">

                                                @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Discount Price --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Discount Price
                                                </label>

                                                <input type="number" name="discount_price" step="0.01" min="0"
                                                    value="{{ old('discount_price') }}"
                                                    class="form-control @error('discount_price') is-invalid @enderror"
                                                    placeholder="0.00">

                                                @error('discount_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Stock --}}
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Stock
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" name="stock" min="0"
                                                    value="{{ old('stock', 0) }}"
                                                    class="form-control @error('stock') is-invalid @enderror">

                                                @error('stock')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Sizes --}}
                                        <div class="col-md-8">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Available Sizes
                                                </label>

                                                <select name="sizes[]" class="form-control" multiple>
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->id }}" @selected(in_array($size->id, old('size_ids', [])))>
                                                            {{ $size->size_name }}
                                                            @if ($size->size_type)
                                                                - {{ ucfirst($size->size_type) }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Featured --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Featured
                                                </label>

                                                <select name="featured" class="form-control">
                                                    <option value="0" @selected(old('featured', '0') == '0')>
                                                        No
                                                    </option>

                                                    <option value="1" @selected(old('featured') == '1')>
                                                        Yes
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Status
                                                </label>

                                                <select name="status" class="form-control">
                                                    <option value="1" @selected(old('status', '1') == '1')>
                                                        Active
                                                    </option>

                                                    <option value="0" @selected(old('status') == '0')>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Product Image --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Main Image
                                                </label>

                                                <input type="file" name="image"
                                                    class="form-control @error('image') is-invalid @enderror">

                                                @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Multiple Images --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Gallery Images
                                                </label>

                                                <input type="file" name="gallery_images[]" class="form-control"
                                                    multiple>
                                            </div>
                                        </div>

                                        {{-- Short Description --}}
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Short Description
                                                </label>

                                                <textarea name="short_description" rows="3" class="form-control" placeholder="Short product description">{{ old('short_description') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Description
                                                </label>

                                                <textarea name="description" rows="6" class="form-control" placeholder="Complete product description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>

                                        {{-- SEO --}}
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Meta Title
                                                </label>

                                                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Meta Keywords
                                                </label>

                                                <input type="text" name="meta_keywords"
                                                    value="{{ old('meta_keywords') }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Meta Description
                                                </label>

                                                <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Canonical URL
                                                </label>

                                                <input type="url" name="canonical_url"
                                                    value="{{ old('canonical_url') }}" class="form-control"
                                                    placeholder="https://example.com/product/...">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label">
                                                    Index Status
                                                </label>

                                                <select name="index_status" class="form-control">
                                                    <option value="1" @selected(old('index_status', '1') == '1')>
                                                        Index
                                                    </option>

                                                    <option value="0" @selected(old('index_status') == '0')>
                                                        No Index
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-4">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <p><span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean"
                        target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank"
                        href="https://themewagon.com" target="_blank">ThemeWagon</a></span></p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
        <!-- [ Footer ] end -->
    </main>

@endsection
