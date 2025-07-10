<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lokasi::create([
            'kode_lokasi' => 'L001',
            'nama_lokasi' => 'Gudang Timur',
            'penanggung_jawab' => 'Budi Santoso',
        ]);
        Lokasi::create([
            'kode_lokasi' => 'L002',
            'nama_lokasi' => 'Gudang Selatan',
            'penanggung_jawab' => 'Siti Aminah',
        ]);

        Lokasi::create([
            'kode_lokasi' => 'L003',
            'nama_lokasi' => 'Gudang Tenggara',
            'penanggung_jawab' => 'Andi Wijaya',
        ]);
    }
}
