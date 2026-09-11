<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;

// Page d'accueil (Home)
Route::get('/', [ProductController::class, 'home'])->name('home');

// Routes des Produits
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Routes de Modification (Édition)
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Suppression et mise à jour de stock
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.updateStock');

// Route des Mouvements
Route::get('/movements', [StockMovementController::class, 'index'])->name('movements.index');