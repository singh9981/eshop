<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminCategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });
dd('sdfdsf');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('super-admin')->middleware(['auth','role:super_admin'])->group(function () {
    Route::get('/dashboard',[SuperAdminDashboardController::class,'index'])->name('super.admin.dashboard');
    
    // Category
    Route::get('/category',[SuperAdminCategoryController::class,'index'])->name('super.admin.category');
    Route::get('/category/create',[SuperAdminCategoryController::class,'create'])->name('super.admin.create');
    
});

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::prefix('user')->middleware(['auth','role:user'])->group(function () {
    Route::get('/user-profile', [UserProfileController::class,'index'])->name('user.profile'); 
});
Route::get('/products',[UserProductController::class,'index'])->name('user.products');
Route::get('/products-details/{id}',[UserProductController::class,'show'])->name('user.product.show');
Route::get('/contant',[ContactController::class,'index'])->name('user.contact');