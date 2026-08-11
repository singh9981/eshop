<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SizeRequest;
use App\Models\Size;
use App\Services\SuperAdmin\SizeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SuperAdminSizeController extends Controller
{
    public function __construct(
        private readonly SizeService $sizeService
    ) {}

    public function index(): View
    {
        $sizes = $this->sizeService->getAllSizes();

        $module_name = "Size";
        $module_url = "super.admin.size.create";

        return view(
            'SuperAdmin.sizes.list',
            compact('sizes','module_name','module_url')
        );
    }

    public function create(): View
    {
        $module_name = "Size";
        $module_url = "super.admin.size.create";
        return view('SuperAdmin.sizes.create');
    }

    public function store(
        SizeRequest $request
    ): RedirectResponse {
        try {
            $this->sizeService->createSize(
                $request->validated()
            );

            return redirect()
                ->route('super.admin.sizes.list')
                ->with('success', 'Size created successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Size $size): View
    {
        return view(
            'SuperAdmin.sizes.edit',
            compact('size')
        );
    }

    public function update(
        SizeRequest $request,
        Size $size
    ): RedirectResponse {
        try {
            $this->sizeService->updateSize(
                $size,
                $request->validated()
            );

            return redirect()
                ->route('super.admin.sizes.list')
                ->with('success', 'Size updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(
        Size $size
    ): RedirectResponse {
        try {
            $this->sizeService->deleteSize($size);

            return back()
                ->with('success', 'Size deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->with('error', $exception->getMessage());
        }
    }
}
