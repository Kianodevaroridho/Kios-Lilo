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
        // ========== USER (1 akun untuk semua) ==========
        User::create([
            'name' => 'Admin Kios Lilo',
            'email' => 'admin@kioslilo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // ========== CATEGORIES (Perlengkapan Baso) ==========
        $bahanBaku = Category::create([
            'name' => 'Bahan Baku',
            'description' => 'Daging, tepung, dan bumbu inti',
        ]);

        $pelengkap = Category::create([
            'name' => 'Topping & Pelengkap',
            'description' => 'Mie, sayuran, dan pelengkap mangkok',
        ]);

        $bumbu = Category::create([
            'name' => 'Bumbu & Saos',
            'description' => 'Kecap, saos, sambal, dan penyedap',
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'description' => 'Berbagai macam minuman dingin dan hangat',
        ]);

        $kemasan = Category::create([
            'name' => 'Kemasan',
            'description' => 'Mangkok plastik, kantong, dan sendok bebek',
        ]);

        // ========== PRODUCTS (Perlengkapan Baso) ==========
        
        // Bahan Baku
        Product::create([
            'name' => 'Daging Sapi Giling (1kg)',
            'category_id' => $bahanBaku->id,
            'price' => 125000,
            'stock' => 10,
            'barcode' => 'BS001',
        ]);

        Product::create([
            'name' => 'Bakso Halus (50 butir)',
            'category_id' => $bahanBaku->id,
            'price' => 75000,
            'stock' => 20,
            'barcode' => 'BS002',
        ]);

        Product::create([
            'name' => 'Bakso Urat Besar (10 butir)',
            'category_id' => $bahanBaku->id,
            'price' => 85000,
            'stock' => 15,
            'barcode' => 'BS003',
        ]);

        Product::create([
            'name' => 'Tepung Tapioka (1kg)',
            'category_id' => $bahanBaku->id,
            'price' => 15000,
            'stock' => 50,
            'barcode' => 'BS004',
        ]);

        // Topping & Pelengkap
        Product::create([
            'name' => 'Mie Kuning Basah (1kg)',
            'category_id' => $pelengkap->id,
            'price' => 12000,
            'stock' => 25,
            'barcode' => 'BS005',
        ]);

        Product::create([
            'name' => 'Bihun Jagung (Pack)',
            'category_id' => $pelengkap->id,
            'price' => 8000,
            'stock' => 30,
            'barcode' => 'BS006',
        ]);

        Product::create([
            'name' => 'Tahu Bakso (10 biji)',
            'category_id' => $pelengkap->id,
            'price' => 25000,
            'stock' => 12,
            'barcode' => 'BS007',
        ]);

        Product::create([
            'name' => 'Bawang Goreng (250gr)',
            'category_id' => $pelengkap->id,
            'price' => 35000,
            'stock' => 8,
            'barcode' => 'BS008',
        ]);

        // Bumbu & Saos
        Product::create([
            'name' => 'Saos Sambal Pedas (1kg)',
            'category_id' => $bumbu->id,
            'price' => 22000,
            'stock' => 10,
            'barcode' => 'BS009',
        ]);

        Product::create([
            'name' => 'Kecap Manis Jerigen (5kg)',
            'category_id' => $bumbu->id,
            'price' => 110000,
            'stock' => 5,
            'barcode' => 'BS010',
        ]);

        // Minuman
        Product::create([
            'name' => 'Teh Manis Cup',
            'category_id' => $minuman->id,
            'price' => 5000,
            'stock' => 100,
            'barcode' => 'BS011',
        ]);

        Product::create([
            'name' => 'Es Jeruk',
            'category_id' => $minuman->id,
            'price' => 7000,
            'stock' => 40,
            'barcode' => 'BS012',
        ]);

        // Kemasan
        Product::create([
            'name' => 'Mangkok Plastik (50 pcs)',
            'category_id' => $kemasan->id,
            'price' => 45000,
            'stock' => 20,
            'barcode' => 'BS013',
        ]);

        Product::create([
            'name' => 'Sendok Bebek Plastik (Pack)',
            'category_id' => $kemasan->id,
            'price' => 15000,
            'stock' => 50,
            'barcode' => 'BS014',
        ]);
    }
}
