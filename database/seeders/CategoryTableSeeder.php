<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            // Gender
            ['name' => 'Hombre', 'type' => 'gender'],
            ['name' => 'Mujer', 'type' => 'gender'],
            ['name' => 'Niños', 'type' => 'gender'],

            // Type of use
            ['name' => 'Casual', 'type' => 'usage'],
            ['name' => 'Running', 'type' => 'usage'],
            ['name' => 'Basketball', 'type' => 'usage'],
            ['name' => 'Skate', 'type' => 'usage'],
            ['name' => 'Training', 'type' => 'usage'],
            ['name' => 'Football', 'type' => 'usage'],

            // Brand
            ['name' => 'Nike', 'type' => 'brand'],
            ['name' => 'Jordan', 'type' => 'brand'],
            ['name' => 'Adidas', 'type' => 'brand'],
            ['name' => 'Puma', 'type' => 'brand'],
            ['name' => 'Reebok', 'type' => 'brand'],
            ['name' => 'New Balance', 'type' => 'brand'],
            ['name' => 'Converse', 'type' => 'brand'],
            ['name' => 'Lacoste', 'type' => 'brand'],
            ['name' => 'Vans', 'type' => 'brand'],
        ]);
    }
}
