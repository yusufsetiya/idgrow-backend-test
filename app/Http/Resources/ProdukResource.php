<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'kategori_id' => $this->kategori,
            'satuan' => $this->satuan,
            'deskripsi' => $this->deskripsi,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
