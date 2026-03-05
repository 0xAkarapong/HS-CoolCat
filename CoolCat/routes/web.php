<?php

use App\Http\Controllers\CatInquiryController;
use App\Http\Controllers\CatListingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Shop — owner actions (auth required, registered first so /create isn't swallowed by {product})
Route::middleware('auth')->group(function () {
    Route::resource('listings', CatListingController::class)->except(['index', 'show']);
    Route::resource('products', ProductController::class)->except(['index', 'show']);

    // Inquiries — shallow nested under listings
    Route::resource('listings.inquiries', CatInquiryController::class)
        ->shallow()
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});

// Shop — public browsing
Route::resource('listings', CatListingController::class)->only(['index', 'show']);
Route::resource('products', ProductController::class)->only(['index', 'show']);

require __DIR__.'/settings.php';
