<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'ENLATADOS',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'CEREALES',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'LÁCTEOS',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'CARNES',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'PANADERÍA',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'BEBIDAS',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'LIMPIEZA',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'CONDIMENTOS',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'DULCES',
            'image' => 'http://dummyimage.com/200x150/5c5756/fff'
        ]);
    }
}
