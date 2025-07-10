<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriProduk::create([
            'nama_kategori' => 'Perkakas',
            'deskripsi' => 'Kategori untuk produk perkakas.',
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Kategori untuk produk makanan dan minuman',
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'Alumunium',
            'deskripsi' => 'Kategori untuk produk berbahan alumunium',
        ]);
    }
}
