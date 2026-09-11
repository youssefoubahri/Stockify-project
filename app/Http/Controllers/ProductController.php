<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Afficher la page d'accueil
    public function home()
    {
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'alert_stock')->count();
        $totalMovements = StockMovement::count();
        $recentProducts = Product::latest()->take(5)->get();

        return view('home', compact('totalProducts', 'lowStockProducts', 'totalMovements', 'recentProducts'));
    }

    // Afficher la liste de tous les produits
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Enregistrer un nouveau produit + mouvement de stock
    public function store(Request $request)
    { 
        // 1. Validation des données
        $validated = $request->validate([
            'reference'   => 'required|unique:products,reference',
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'alert_stock' => 'required|integer|min:0',
        ]);

        // 2. Création du produit
        $product = Product::create($validated);

        // 3. Enregistrement automatique de l'entrée dans l'historique
        if ($product->quantity > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type'       => 'entrée',
                'quantity'   => $product->quantity,
                'reason'     => 'Stock initial (Création)',
            ]);
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produit ajouté et mouvement enregistré avec succès !');
    }

    // Afficher le formulaire de modification du produit
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Mettre à jour le produit en base de données
    public function update(Request $request, Product $product)
    {
        // 1. Validation des données (la référence doit ignorer le produit actuel)
        $validated = $request->validate([
            'reference'   => 'required|unique:products,reference,' . $product->id,
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'alert_stock' => 'required|integer|min:0',
        ]);

        // 2. Mise à jour des informations
        $product->update($validated);

        return redirect()->route('products.index')
                         ->with('success', 'Produit mis à jour avec succès !');
    }

    // Supprimer un produit + mouvement de stock
    public function destroy(Product $product)
    {
        // 1. Enregistrement automatique de la sortie dans l'historique
        if ($product->quantity > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type'       => 'sortie',
                'quantity'   => $product->quantity,
                'reason'     => 'Suppression du produit',
            ]);
        }

        // 2. Suppression du produit
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Produit supprimé avec succès !');
    }
}