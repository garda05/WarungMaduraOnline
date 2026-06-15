<?php

namespace Database\Seeders;

use App\Models\Barang;
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
        $penjual = User::updateOrCreate([
            'email' => 'penjual@warung.test',
        ], [
            'name' => 'Penjual Selenium',
            'email_verified_at' => now(),
            'password' => 'password123',
            'role' => 'penjual',
        ]);

        User::updateOrCreate([
            'email' => 'pembeli@warung.test',
        ], [
            'name' => 'Pembeli Selenium',
            'email_verified_at' => now(),
            'password' => 'password123',
            'role' => 'pembeli',
        ]);

        Barang::updateOrCreate([
            'user_id' => $penjual->id,
            'nama_barang' => 'Kopi Madura Selenium',
        ], [
            'harga' => 12000,
            'stok' => 100,
            'deskripsi' => 'Produk stabil untuk pengujian otomatis.',
            'kategori' => 'minuman',
        ]);
    }
}
