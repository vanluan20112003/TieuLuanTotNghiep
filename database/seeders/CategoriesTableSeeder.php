<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Chocolate Cakes',
                'product_count' => 10,
                'image' => 'chocolate_cakes.jpg',
            ],
            [
                'name' => 'Vanilla Cakes',
                'product_count' => 5,
                'image' => 'vanilla_cakes.jpg',
            ],
            [
                'name' => 'Fruit Cakes',
                'product_count' => 8,
                'image' => 'fruit_cakes.jpg',
            ],
            [
                'name' => 'Cheesecakes',
                'product_count' => 7,
                'image' => 'cheesecakes.jpg',
            ],
        ]);
    }
}
