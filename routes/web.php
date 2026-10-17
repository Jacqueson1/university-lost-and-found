<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('items.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public pages
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show')->whereNumber('item');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/my-claims', [ClaimController::class, 'index'])->name('claims.index');
    Route::post('/items/{item}/claim', [ClaimController::class, 'store'])->name('claims.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin pages
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/items', [AdminController::class, 'items'])->name('items');
    Route::delete('/items/{item}', [AdminController::class, 'destroyItem'])->name('items.destroy');
    Route::get('/claims', [AdminController::class, 'claims'])->name('claims');
    Route::get('/claims/{claim}', [AdminController::class, 'showClaim'])->name('claims.show');
    Route::post('/claims/{claim}/approve', [AdminController::class, 'approveClaim'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [AdminController::class, 'rejectClaim'])->name('claims.reject');
});


require __DIR__ . '/auth.php';
