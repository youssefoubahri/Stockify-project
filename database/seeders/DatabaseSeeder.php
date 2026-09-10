<?php

//namespace Database\Seeders;

//use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;

//class DatabaseSeeder extends Seeder
//{
  //  use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    //public function run(): void
   // {
        // User::factory(10)->create();

     //   User::factory()->create([
       //     'name' => 'Test User',
         //   'email' => 'test@example.com',
        //]);
    //}
//}


namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des catégories
        $electronique = Category::create(['name' => 'Électronique', 'description' => 'Gadgets et composants']);
        $bureautique = Category::create(['name' => 'Bureautique', 'description' => 'Fournitures de bureau']);

        // 2. Création des produits de test
        Product::create([
            'category_id' => $electronique->id,
            'reference' => 'PC-001',
            'name' => 'PC Portable Dell',
            'price' => 7500.00,
            'quantity' => 15,
            'alert_stock' => 5,
        ]);

        Product::create([
            'category_id' => $electronique->id,
            'reference' => 'MOUSE-002',
            'name' => 'Souris Sans Fil',
            'price' => 150.00,
            'quantity' => 3, // En dessous du seuil d'alerte (badge rouge)
            'alert_stock' => 5,
        ]);

        Product::create([
            'category_id' => $bureautique->id,
            'reference' => 'PAP-003',
            'name' => 'Rame de Papier A4',
            'price' => 45.00,
            'quantity' => 50,
            'alert_stock' => 10,
        ]);
    }
}