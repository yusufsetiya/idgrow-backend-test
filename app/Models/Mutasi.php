<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $table = 'mutasi';
    protected $fillable = [
        'tanggal',
        'jenis_mutasi', 
        'jumlah',
        'keterangan',
        'produk_lokasi_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class);
    }
}
