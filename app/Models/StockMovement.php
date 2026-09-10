<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'type',      // 'entrée' ou 'sortie'
        'quantity',
        'reason',    // Ex: "Stock initial (Création)", "Suppression du produit"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}