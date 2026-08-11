<?php

namespace App\Services\SuperAdmin;

use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SizeService
{
    public function getAllSizes()
    {
        return Size::query()
            ->orderBy('sort_order')
            ->orderBy('size_name')
            ->paginate(10);
    }

    public function getSizeById(int $id): Size
    {
        return Size::findOrFail($id);
    }

    public function createSize(array $data): Size
    {
        return DB::transaction(function () use ($data) {

            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'] ?? $data['size_name']
            );

            $data['sort_order'] = $data['sort_order'] ?? 0;
            $data['status'] = $data['status'] ?? true;

            return Size::create($data);
        });
    }

    public function updateSize(
        Size $size,
        array $data
    ): Size {
        return DB::transaction(function () use ($size, $data) {

            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'] ?? $data['size_name'],
                $size->id
            );

            $size->update($data);

            return $size->fresh();
        });
    }

    public function deleteSize(Size $size): bool
    {
        return DB::transaction(function () use ($size) {
            return $size->delete();
        });
    }

    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Size::query()
            ->where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
