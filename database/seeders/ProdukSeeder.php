<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'kode_produk' => 'P001',
            'nama_produk' => 'Smartphone XYZ',
            'kategori_id' => 1, // Asumsikan kategori ID 1 adalah Elektronik
            'satuan' => 'pcs',
            'deskripsi' => 'Smartphone dengan spesifikasi tinggi dan kamera canggih.',
            'harga_beli' => 4500000,
            'harga_jual' => 5000000,
        ]);

        Produk::create([
            'kode_produk' => 'P002',
            'nama_produk' => 'Kecap',
            'kategori_id' => 2, // Asumsikan kategori ID 1 adalah Elektronik
            'satuan' => 'pcs',
            'deskripsi' => 'Kecap enak dan manis.',
            'harga_beli' => 12000,
            'harga_jual' => 14000,
        ]);

        Produk::create([
            'kode_produk' => 'P003',
            'nama_produk' => 'Kemeja Formal',
            'kategori_id' => 3, // Asumsikan kategori ID 3 adalah Pakaian
            'satuan' => 'pcs',
            'deskripsi' => 'Kemeja formal untuk acara bisnis dan resmi.',
            'harga_beli' => 200000,
            'harga_jual' => 250000,
        ]);
    }
}
