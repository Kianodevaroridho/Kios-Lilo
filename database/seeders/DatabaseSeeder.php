<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
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
        // ========== USERS ==========
        User::create([
            'name' => 'Admin POS',
            'email' => 'admin@pos.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@pos.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@pos.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);

        // ========== CATEGORIES ==========
        $makananRingan = Category::create([
            'name' => 'Makanan Ringan',
            'description' => 'Berbagai macam snack dan makanan ringan',
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'description' => 'Minuman dingin dan panas',
        ]);

        $rokok = Category::create([
            'name' => 'Rokok',
            'description' => 'Berbagai merek rokok',
        ]);

        $kebutuhanHarian = Category::create([
            'name' => 'Kebutuhan Harian',
            'description' => 'Sabun, shampo, dan kebutuhan sehari-hari',
        ]);

        $mieInstan = Category::create([
            'name' => 'Mie Instan',
            'description' => 'Berbagai merek mie instan',
        ]);

        // ========== PRODUCTS ==========
        // Makanan Ringan
        Product::create([
            'name' => 'Chitato Sapi Panggang',
            'category_id' => $makananRingan->id,
            'price' => 12000,
            'stock' => 50,
            'barcode' => '8990123456789',
        ]);

        Product::create([
            'name' => 'Lays Rumput Laut',
            'category_id' => $makananRingan->id,
            'price' => 10000,
            'stock' => 40,
            'barcode' => '8990123456790',
        ]);

        Product::create([
            'name' => 'Oreo Original',
            'category_id' => $makananRingan->id,
            'price' => 5000,
            'stock' => 60,
            'barcode' => '8990123456791',
        ]);

        Product::create([
            'name' => 'Tango Wafer Coklat',
            'category_id' => $makananRingan->id,
            'price' => 7500,
            'stock' => 35,
            'barcode' => '8990123456792',
        ]);

        // Minuman
        Product::create([
            'name' => 'Teh Pucuk Harum',
            'category_id' => $minuman->id,
            'price' => 4000,
            'stock' => 100,
            'barcode' => '8991234567890',
        ]);

        Product::create([
            'name' => 'Aqua 600ml',
            'category_id' => $minuman->id,
            'price' => 4000,
            'stock' => 120,
            'barcode' => '8991234567891',
        ]);

        Product::create([
            'name' => 'Coca Cola 390ml',
            'category_id' => $minuman->id,
            'price' => 7000,
            'stock' => 48,
            'barcode' => '8991234567892',
        ]);

        Product::create([
            'name' => 'Kopi Good Day Cappuccino',
            'category_id' => $minuman->id,
            'price' => 3000,
            'stock' => 80,
            'barcode' => '8991234567893',
        ]);

        // Rokok
        Product::create([
            'name' => 'Gudang Garam Surya 16',
            'category_id' => $rokok->id,
            'price' => 30000,
            'stock' => 25,
            'barcode' => '8992345678901',
        ]);

        Product::create([
            'name' => 'Sampoerna Mild',
            'category_id' => $rokok->id,
            'price' => 28000,
            'stock' => 30,
            'barcode' => '8992345678902',
        ]);

        // Kebutuhan Harian
        Product::create([
            'name' => 'Sabun Lifebuoy',
            'category_id' => $kebutuhanHarian->id,
            'price' => 3500,
            'stock' => 45,
            'barcode' => '8993456789012',
        ]);

        Product::create([
            'name' => 'Shampo Pantene Sachet',
            'category_id' => $kebutuhanHarian->id,
            'price' => 1000,
            'stock' => 200,
            'barcode' => '8993456789013',
        ]);

        Product::create([
            'name' => 'Pasta Gigi Pepsodent',
            'category_id' => $kebutuhanHarian->id,
            'price' => 8000,
            'stock' => 3, // stok menipis untuk testing
            'barcode' => '8993456789014',
        ]);

        // Mie Instan
        Product::create([
            'name' => 'Indomie Goreng',
            'category_id' => $mieInstan->id,
            'price' => 3500,
            'stock' => 150,
            'barcode' => '8994567890123',
        ]);

        Product::create([
            'name' => 'Indomie Soto',
            'category_id' => $mieInstan->id,
            'price' => 3000,
            'stock' => 100,
            'barcode' => '8994567890124',
        ]);

        Product::create([
            'name' => 'Mie Sedaap Goreng',
            'category_id' => $mieInstan->id,
            'price' => 3500,
            'stock' => 2, // stok menipis untuk testing
            'barcode' => '8994567890125',
        ]);
    }
}
