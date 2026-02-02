<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriKeuangan;
use App\Models\AkunKeuangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Memanggil UserSeeder (Pastikan UserSeeder sudah diperbaiki dari error truncate sebelumnya)
        $this->call([
            UserSeeder::class,
        ]);

        // 2. Tambahan User (Jika ingin tambah di sini juga)
        User::create([
            'name' => 'Admin Keuangan',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 3. Seed Kategori Keuangan
        $kategori = [
            ['nama' => 'Gaji & Bonus', 'tipe' => 'pemasukan'],
            ['nama' => 'Investasi', 'tipe' => 'pemasukan'],
            ['nama' => 'Makanan & Minuman', 'tipe' => 'pengeluaran'],
            ['nama' => 'Transportasi', 'tipe' => 'pengeluaran'],
            ['nama' => 'Belanja Otomotif', 'tipe' => 'pengeluaran'],
            ['nama' => 'Tagihan Listrik/Air', 'tipe' => 'pengeluaran'],
            ['nama' => 'Hiburan', 'tipe' => 'pengeluaran'],
        ];

        foreach ($kategori as $k) {
            KategoriKeuangan::create($k);
        }

        // Di DatabaseSeeder.php
        AkunKeuangan::create([
            'nama_akun' => 'Dompet Tunai',
            'jenis' => 'tunai',
            'saldo_awal' => 500000,
            // Hapus dulu saldo_saat_ini jika kolomnya tidak ada di migrasi
        ]);

        AkunKeuangan::create([
            'nama_akun' => 'Bank BCA',
            'jenis' => 'bank',
            'saldo_awal' => 2000000,
        ]);
    }
}