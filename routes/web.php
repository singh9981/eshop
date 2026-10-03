<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdmin\SuperAdminBrandController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminCategoryController;
use App\Http\Controllers\SuperAdmin\SuperAdminSizeController;
use App\Http\Controllers\SuperAdmin\SuperAdminProductController;
use App\Http\Controllers\SuperAdmin\SuperAdminContactController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('super-admin')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('super.admin.dashboard');

    // Category
    Route::get('/category', [SuperAdminCategoryController::class, 'index'])->name('super.admin.category');
    Route::get('/category/create', [SuperAdminCategoryController::class, 'create'])->name('super.admin.create');
    Route::post('/category/store', [SuperAdminCategoryController::class, 'store'])->name('super.admin.store');
    Route::get('/category/{category}/edit', [SuperAdminCategoryController::class, 'edit'])->name('super.admin.edit');
    Route::put('/category/update', [SuperAdminCategoryController::class, 'update'])->name('super.admin.update');
    Route::delete('/category/delete/{category}', [SuperAdminCategoryController::class, 'destroy'])->name('super.admin.destroy');

    // Brand
    Route::get('/brand', [SuperAdminBrandController::class, 'index'])->name('super.admin.brand');
    Route::get('/brand/create', [SuperAdminBrandController::class, 'create'])->name('super.admin.brand.create');
    Route::post('/brand/store', [SuperAdminBrandController::class, 'store'])->name('super.admin.brand.store');
    Route::get('/brand/{brand}/edit', [SuperAdminBrandController::class, 'edit'])->name('super.admin.brand.edit');
    Route::put('/brand/update', [SuperAdminBrandController::class, 'update'])->name('super.admin.brand.update');
    Route::delete('/brand/delete/{brand}', [SuperAdminBrandController::class, 'destroy'])->name('super.admin.brand.destroy');

    //Size
    Route::get('/size', [SuperAdminSizeController::class, 'index'])->name('super.admin.size');
    Route::get('/size/create', [SuperAdminSizeController::class, 'create'])->name('super.admin.size.create');
    Route::post('/size/store', [SuperAdminSizeController::class, 'store'])->name('super.admin.size.store');

    //Product
    Route::name('super.admin.')->group(function () {

        Route::resource('product', SuperAdminProductController::class);
        Route::post('product/{product}/image/{image}/primary', [SuperAdminProductController::class, 'setPrimaryImage'])->name('product.image.primary');
        Route::delete('product/{product}/image/{image}', [SuperAdminProductController::class, 'deleteImage'])->name('product.image.delete');
        Route::post('ajaxsubcategory', [SuperAdminProductController::class, 'subCategoryajax'])->name('superadmin.subcategory');
    });
    // Contact us List
    Route::get('/contact-list', [SuperAdminContactController::class, 'index'])->name('super.admin.contact');
    Route::get('/contact', [SuperAdminContactController::class, 'create'])->name('super.admin.contact.create');


});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::prefix('user')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user.profile');
});
Route::get('/products', [UserProductController::class, 'index'])->name('user.products');
Route::get('/products-details/{id}', [UserProductController::class, 'show'])->name('user.product.show');
Route::get('/contant', [ContactController::class, 'index'])->name('user.contact');
