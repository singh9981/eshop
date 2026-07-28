<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\CategoryRequest;
use App\Models\Category;
use App\Services\SuperAdmin\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class SuperAdminCategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

        return view('SuperAdmin.Category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parentCategories = $this->categoryService->getParentCategories();

        return view('SuperAdmin.Category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            Log::info('Category create request started', [
                'request_data' => $request->except([
                    'image',
                    '_token',
                ]),
                'has_image' => $request->hasFile('image'),
            ]);

            $category = $this->categoryService->createCategory(
                $request->validated()
            );

            Log::info('Category created successfully', [
                'category_id' => $category->id,
                'category_name' => $category->categorys_name,
            ]);

                
            return redirect()
                ->route('super.admin.category')
                ->with(
                    'success',
                    'Category created successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->with('error','Category could not be created.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $parentCategories = $this->categoryService->getParentCategories($category->id);

        return view('SuperAdmin.Category.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $this->categoryService->updateCategory(
                $category,
                $request->validated()
            );

            return redirect()
                ->route('super.admin.category')
                ->with(
                    'success',
                    'Category updated successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $this->categoryService
                ->deleteCategory($category);

            return back()->with(
                'success',
                'Category deleted successfully.'
            );
        } catch (Throwable $exception) {
            return back()->with(
                'error',
                $exception->getMessage()
            );
        }
    }
}
