<?php

namespace App\Services\SuperAdmin;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CategoryService
{
    /**
     * Category listing.
     */
    public function getAllCategories()
    {
        return Category::with('parent')
            ->orderBy('sort_order')
            ->orderBy('category_name')
            ->get();
    }

    /**
     * Sirf parent categories.
     */
    public function getParentCategories(?int $excludeCategoryId = null)
    {
        return Category::query()
            ->whereNull('parent_id')
            ->when($excludeCategoryId, function ($query) use ($excludeCategoryId) {
                $query->where('id', '!=', $excludeCategoryId);
            })
            ->where('status', true)
            ->orderBy('category_name')
            ->get();
    }
    public function getCategoryById(int $id)
    {
       
        return Category::findOrFail($id);
    }
    /**
     * Parent aur nested child categories.
     */
    public function getCategoryTree()
    {
        return Category::query()
            ->with('childrenRecursive')
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('category_name')
            ->get();
    }

    /**
     * Category create.
     *
     * @throws Throwable
     */
    public function createCategory(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'] ?? $data['category_name']
            );

            if (
                isset($data['image']) &&
                $data['image'] instanceof UploadedFile
            ) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $data['parent_id'] = $data['parent_id'] ?? null;
            $data['status'] = $data['status'] ?? true;
            $data['sort_order'] = $data['sort_order'] ?? 0;

            return Category::create($data);
        });
    }

    /**
     * Category update.
     *
     * @throws Throwable
     */
    public function updateCategory(
        Category $category,
        array $data
    ): Category {
        return DB::transaction(function () use ($category, $data) {

            if (
                isset($data['parent_id']) &&
                (int) $data['parent_id'] === $category->id
            ) {
                throw new \InvalidArgumentException(
                    'Category cannot be its own parent.'
                );
            }

            $data['slug'] = $this->generateUniqueSlug(
                $data['slug'] ?? $data['category_name'],
                $category->id
            );

            if (
                isset($data['image']) &&
                $data['image'] instanceof UploadedFile
            ) {
                $this->deleteImage($category->image);

                $data['image'] = $this->uploadImage($data['image']);
            }

            $category->update($data);

            return $category->fresh(['parent', 'children']);
        });
    }

    /**
     * Category delete.
     *
     * @throws Throwable
     */
    public function deleteCategory(Category $category): bool
    {
        return DB::transaction(function () use ($category) {

            if ($category->children()->exists()) {
                throw new \RuntimeException(
                    'Please delete or move child categories first.'
                );
            }

            $this->deleteImage($category->image);

            return $category->delete();
        });
    }

    /**
     * Category status change.
     */
    public function changeStatus(
        Category $category,
        bool $status
    ): Category {
        $category->update([
            'status' => $status,
        ]);

        return $category->fresh();
    }

    /**
     * Unique slug generate.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Category::query()
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

    /**
     * Category image upload.
     */
    private function uploadImage(UploadedFile $image): string
    {
        return $image->store('categories', 'public');
    }

    /**
     * Old category image delete.
     */
    private function deleteImage(?string $imagePath): void
    {
        if (
            $imagePath &&
            Storage::disk('public')->exists($imagePath)
        ) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
