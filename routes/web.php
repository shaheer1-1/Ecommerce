<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/documents/unauth/download/{type}/{id}/{action}', [DocumentController::class, 'secureUnauthDocumentDownload'])->name('document.unauth.download');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::prefix('/profile/payment-methods')->name('profile.payment-methods.')->group(function () {
        Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
        Route::patch('/{paymentMethod}/primary', [PaymentMethodController::class, 'makePrimary'])->name('primary');
    });
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::get('/remove/{item}', [CartController::class, 'remove'])->name('remove');
    });
    Route::prefix('/checkout')->name('checkout.')->group(function () {
        Route::get('/', [OrderController::class, 'checkout'])->name('index');
        Route::post('/', [OrderController::class, 'placeOrder'])->name('placeOrder');
    });
    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
    Route::get('/settings', [SettingController::class, 'settings'])->name('settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'adminprofile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/documents/download/{type}/{id}/{action}', [DocumentController::class, 'secureDocumentDownload'])->name('document.download');
});
require __DIR__.'/auth.php';
