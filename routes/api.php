<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopifyController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/sync', [ShopifyController::class, 'syncProducts']);
    Route::get('/shopify', [ShopifyController::class, 'getShopifyProducts']);
});
