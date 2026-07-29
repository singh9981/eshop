@extends('layouts.superadmin.app')
@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Proposal</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Create</li>
                </ul>
            </div>
        </div>
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
                        <form action="{{ route('super.admin.update') }}" method="put" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $parentCategoriesEdit->id ?? '' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <input type="text"
                                                name="category_name"
                                                id="category_name"
                                                value="{{ old('category_name', $parentCategoriesEdit->category_name ?? '') }}"
                                                class="form-control @error('category_name') is-invalid @enderror"
                                                placeholder="Category">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                                            <input type="text"
                                                name="slug"
                                                id="slug"
                                                value="{{ old('slug',$parentCategoriesEdit->slug ?? '') }}"
                                                class="form-control @error('slug') is-invalid @enderror"
                                                placeholder="slug">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                            <select class="form-control" data-select2-selector="icon" name="parent_id">
                                                <option value="">Main Category</option>
                                                @foreach ($parentCategories as $parentCategory)
                                                <option value="{{ $parentCategory->id }}"
                                                    @selected(old('parent_id', $category->parent_id) == $parentCategory->id)>
                                                    {{ $parentCategory->category_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                                <option value="1" @selected(old('status', '1' )=='1' )> Active </option>
                                                <option value="0" @selected(old('status')=='0' )> Inactive </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Image<span class="text-danger">*</span></label>
                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control @error('image') is-invalid @enderror">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Meta Title<span class="text-danger">*</span></label>
                                    <input type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{ $parentCategoriesEdit->meta_title ?? '' }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Meta Description<span class="text-danger">*</span></label>
                                    <textarea type="text" name="meta_description" class="form-control" placeholder="Meta Description">{{ $parentCategoriesEdit->meta_description ?? '' }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Meta Keyword<span class="text-danger">*</span></label>
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keyword" value="{{ $parentCategoriesEdit->meta_keywords ?? '' }}">
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
        <p><span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean" target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank" href="https://themewagon.com" target="_blank">ThemeWagon</a></span></p>
        <div class="d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
        </div> 
    </footer>
    <!-- [ Footer ] end -->
</main>

@endsection