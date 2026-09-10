<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'name',
        'category_id',
        'price',
        'quantity',
        'alert_stock',
    ];

    // Relation : Un produit appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation : Un produit possède plusieurs mouvements de stock
    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}