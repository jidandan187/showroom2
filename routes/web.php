<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| WEBSITE PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/mobil/{id}', [HomeController::class, 'detail'])
    ->whereNumber('id')
    ->name('mobil.detail');

Route::get('/mobil/{id}/whatsapp', [HomeController::class, 'whatsapp'])
    ->whereNumber('id')
    ->name('mobil.whatsapp');

/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('guest:admin')
    ->group(function () {
        Route::get(
            '/login',
            [AdminAuthenticatedSessionController::class, 'create']
        )->name('login');

        Route::post(
            '/login',
            [AdminAuthenticatedSessionController::class, 'store']
        )->name('login.store');

    });

/*
|--------------------------------------------------------------------------
| USER TEROTENTIKASI
|--------------------------------------------------------------------------
*/

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/{id}', [CartController::class, 'add'])
        ->whereNumber('id')
        ->name('cart.add');

    Route::delete('/cart/{id}', [CartController::class, 'remove'])
        ->whereNumber('id')
        ->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])
        ->name('checkout');

    Route::get('/invoice/{id}/cetak', [InvoiceController::class, 'cetak'])
        ->name('invoice.cetak');
});

/*
|--------------------------------------------------------------------------
| ADMIN TERLINDUNGI
|--------------------------------------------------------------------------
*/

Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::post(
            '/logout',
            [AdminAuthenticatedSessionController::class, 'destroy']
        )->name('logout');

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::resource('mobil', MobilController::class)
            ->except(['show']);

        Route::delete(
            '/mobil-images/{image}',
            [MobilController::class, 'destroyImage']
        )->name('mobil-images.destroy');
    });

/*
|--------------------------------------------------------------------------
| AUTH BAWAAN LARAVEL
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
