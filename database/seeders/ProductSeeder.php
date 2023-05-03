<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Atún de agua',
            'cost' => 35,
            'price' => 20,
            'barcode' => '89768897681',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Ojuelas de maíz',
            'cost' => 20,
            'price' => 50,
            'barcode' => '89768897682',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Leche',
            'cost' => 30,
            'price' => 50,
            'barcode' => '89768897683',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Queso panela grande',
            'cost' => 200,
            'price' => 350,
            'barcode' => '89768897684',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Corte de res',
            'cost' => 60,
            'price' => 120,
            'barcode' => '89768897685',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Dona',
            'cost' => 5,
            'price' => 20,
            'barcode' => '89768897686',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 5,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Soda de limón',
            'cost' => 10,
            'price' => 30,
            'barcode' => '89768897687',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 6,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Jabón en polvo',
            'cost' => 10,
            'price' => 35,
            'barcode' => '89768897688',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 7,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Pimienta',
            'cost' => 30,
            'price' => 60,
            'barcode' => '89768897689',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 8,
            'image' => 'gatosiam.png'
        ]);
        Product::create([
            'name' => 'Crema de maní',
            'cost' => 20,
            'price' => 50,
            'barcode' => '89768897690',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 9,
            'image' => 'gatoprietito.png'
        ]);
    }
}
