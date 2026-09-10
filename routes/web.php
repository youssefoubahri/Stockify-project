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
Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.updateStock');

// Route des Mouvements
Route::get('/movements', [StockMovementController::class, 'index'])->name('movements.index');


// Afficher le formulaire de création et enregistrer
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Supprimer un produit
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');