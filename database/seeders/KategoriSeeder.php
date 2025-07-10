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
            'nama_kategori' => 'Elektronik',
            'deskripsi' => 'Kategori untuk produk elektronik seperti smartphone, laptop, dan perangkat elektronik lainnya.',
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Kategori untuk produk makanan dan minuman',
        ]);

        KategoriProduk::create([
            'nama_kategori' => 'pakaian',
            'deskripsi' => 'Kategori untuk produk pakaian dan aksesori seperti baju, celana, sepatu, dan tas.',
        ]);
    }
}
