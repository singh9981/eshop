<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\BrandRequest;
use App\Models\Brand;
use App\Services\SuperAdmin\BrandService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SuperAdminBrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService
    ) {}

    public function index(): View
    {
        $brands = $this->brandService->getAllBrands();
        $module_name = "Brand";
        $module_url = "super.admin.brand.create";

        return view(
            'SuperAdmin.Brands.list',
            compact('brands','module_name','module_url')
        );
    }

    public function create(): View
    {
        $module_name = "Brand";
        return view('SuperAdmin.Brands.create',compact('module_name'));
    }

    public function store(
        BrandRequest $request
    ): RedirectResponse {
        try {
            $this->brandService->createBrand(
                $request->validated()
            );

            return redirect()
                ->route('super.admin.brand')
                ->with('success', 'Brand created successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Brand $brand): View
    {
        $module_name = "Brand";
        return view(
            'SuperAdmin.Brands.edit',
            compact('brand','module_name')
        );
    }

    public function update(
        BrandRequest $request,
        Brand $brand
    ): RedirectResponse {
        try {
            $this->brandService->updateBrand(
                $brand,
                $request->validated()
            );

            return redirect()
                ->route('super.admin.brand')
                ->with('success', 'Brand updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(
        Brand $brand
    ): RedirectResponse {
        try {
            $this->brandService->deleteBrand($brand);

            return back()
                ->with('success', 'Brand deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with('error', $exception->getMessage());
        }
    }
}
