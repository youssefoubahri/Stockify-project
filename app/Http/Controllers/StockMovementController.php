<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
   public function index()
{
    // Charger la relation 'product' même si le produit a été supprimé
    $movements = StockMovement::with(['product' => function ($query) {
        $query->withTrashed();
    }])->latest()->paginate(15);

    return view('movements.index', compact('movements'));
}
}