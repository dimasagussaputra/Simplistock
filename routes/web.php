<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes yang memerlukan autentikasi (login)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes PRODUK - semua user bisa akses (read), hanya admin yang bisa CUD
    Route::resource('products', ProductController::class);
    Route::patch('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    // Routes TRANSAKSI
    Route::resource('transactions', StockTransactionController::class)->only(['index', 'create', 'store', 'destroy']);

    // Routes KATEGORI - hanya admin
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
    });
});

// Routes bawaan Laravel Breeze (login, register, logout)
require __DIR__.'/auth.php';
