<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin POS',
            'email' => 'admin@pos.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@pos.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);

        $category1 = \App\Models\Category::create([
            'name' => 'Makanan Ringan',
            'description' => 'Berbagai macam snack dan makanan ringan',
        ]);

        $category2 = \App\Models\Category::create([
            'name' => 'Minuman',
            'description' => 'Minuman dingin dan panas',
        ]);

        \App\Models\Product::create([
            'name' => 'Chitato Sapi Panggang',
            'category_id' => $category1->id,
            'price' => 12000,
            'stock' => 50,
            'barcode' => '8990123456789',
        ]);

        \App\Models\Product::create([
            'name' => 'Teh Pucuk Harum',
            'category_id' => $category2->id,
            'price' => 5000,
            'stock' => 100,
            'barcode' => '8991234567890',
        ]);
    }
}
