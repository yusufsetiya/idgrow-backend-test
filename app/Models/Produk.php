<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori_id',
        'satuan',
        'deskripsi',
        'harga_beli',
        'harga_jual',
    ];

    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasi')
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function produkLokasi()
    {
        return $this->hasMany(ProdukLokasi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class);
    }
}
