<?php

namespace App\Services\SuperAdmin;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    public function getAllBrands()
    {
        return Brand::query()
            ->orderBy('sort_order')
            ->orderBy('brand_name')
            ->paginate(10);
    }

    public function createBrand(array $data): Brand
    {
        return DB::transaction(function () use ($data) {

            if (
                isset($data['logo']) &&
                $data['logo'] instanceof UploadedFile
            ) {
                $data['logo'] = $data['logo']
                    ->store('brands', 'public');
            }

            $data['sort_order'] = $data['sort_order'] ?? 0;
            $data['status'] = $data['status'] ?? true;

            return Brand::create($data);
        });
    }

    public function updateBrand(
        Brand $brand,
        array $data
    ): Brand {
        return DB::transaction(function () use ($brand, $data) {

            if (
                isset($data['logo']) &&
                $data['logo'] instanceof UploadedFile
            ) {
                if (
                    $brand->logo &&
                    Storage::disk('public')->exists($brand->logo)
                ) {
                    Storage::disk('public')->delete($brand->logo);
                }

                $data['logo'] = $data['logo']
                    ->store('brands', 'public');
            }

            $brand->update($data);

            return $brand->fresh();
        });
    }

    public function deleteBrand(Brand $brand): bool
    {
        return DB::transaction(function () use ($brand) {

            if (
                $brand->logo &&
                Storage::disk('public')->exists($brand->logo)
            ) {
                Storage::disk('public')->delete($brand->logo);
            }

            return $brand->delete();
        });
    }
}
