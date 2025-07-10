<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukLokasiResource;
use App\Models\ProdukLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkLokasi = ProdukLokasi::with(['produk', 'lokasi'])
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'List Produk Lokasi',
            'data' => ProdukLokasiResource::collection($produkLokasi),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produk,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'stok' => 'required|integer|min:0',
        ], [
            'produk_id.required' => 'Produk wajib dipilih.',
            'produk_id.exists' => 'Produk tidak ditemukan.',
            'lokasi_id.required' => 'Lokasi wajib dipilih.',
            'lokasi_id.exists' => 'Lokasi tidak ditemukan.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek duplikat produk dan lokasi
        $existingEntry = ProdukLokasi::where('produk_id', $request->produk_id)
            ->where('lokasi_id', $request->lokasi_id)
            ->exists();

        if ($existingEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di lokasi ini.',
            ], 409);
        }

        //logic store produk lokasi
        try {
            $produkLokasi = ProdukLokasi::create([
                'produk_id' => $request->produk_id,
                'lokasi_id' => $request->lokasi_id,
                'stok' => $request->stok,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Lokasi produk berhasil ditambahkan.',
                'data' => new ProdukLokasiResource($produkLokasi),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lokasi produk, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //logic find produk lokasi
        $produkLokasi = ProdukLokasi::find($id);
        if ($produkLokasi == null) {
            return response()->json([
                'success' => false,
                'message' => 'Data produk lokasi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data produk lokasi ditemukan.',
            'data' => new ProdukLokasiResource($produkLokasi),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produk,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'stok' => 'required|integer|min:0',
        ], [
            'produk_id.required' => 'Produk wajib dipilih.',
            'produk_id.exists' => 'Produk tidak ditemukan.',
            'lokasi_id.required' => 'Lokasi wajib dipilih.',
            'lokasi_id.exists' => 'Lokasi tidak ditemukan.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        //logic find produk lokasi
        $produkLokasi = ProdukLokasi::find($id);
        if ($produkLokasi == null) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi produk tidak ditemukan.',
            ], 404);
        }
        // Cek duplikat produk dan lokasi
        $existingEntry = ProdukLokasi::where('produk_id', $request->produk_id)
            ->where('lokasi_id', $request->lokasi_id)
            ->where('id', '!=', $id) 
            ->exists();
        
        if ($existingEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di lokasi ini.',
            ], 409);
        }

        //logic update produk lokasi
        try {
            $produkLokasi->update([
                'produk_id' => $request->produk_id,
                'lokasi_id' => $request->lokasi_id,
                'stok' => $request->stok,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Lokasi produk berhasil diperbarui.',
                'data' => new ProdukLokasiResource($produkLokasi),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui lokasi produk, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //logic find produk lokasi
        $produkLokasi = ProdukLokasi::find($id);
        if ($produkLokasi == null) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi produk tidak ditemukan.',
            ], 404);
        }

        //logic delete produk lokasi
        try {
            $produkLokasi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Lokasi produk berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus lokasi produk, silakan coba lagi.',
            ], 500);
        }
    }
}
