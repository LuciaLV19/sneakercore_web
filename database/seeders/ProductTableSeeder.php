<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Nike Air Max', 'price' => 120, 'description' => 'Zapatilla de running para hombre'],
            ['name' => 'Adidas Superstar', 'price' => 90, 'description' => 'Zapatilla casual para mujer'],
            ['name' => 'Puma Suede', 'price' => 85, 'description' => 'Zapatilla casual para niños'],
            ['name' => 'Reebok Nano', 'price' => 100, 'description' => 'Zapatilla de training unisex'],
        ]);
    }
}
