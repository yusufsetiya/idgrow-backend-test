<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukResource;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with(['kategori'])->get();  
        return response()->json([
            'success' => true,
            'message' => 'List Produk',
            'data' => ProdukResource::collection($produk)
        ], 200);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:500',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ],
        [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists' => 'Kategori produk tidak ditemukan.',
            'satuan.required' => 'Satuan produk wajib diisi.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate kode_produk
        $lastKode = Produk::orderBy('kode_produk', 'desc')->value('kode_produk');
        $next = $lastKode ? (int)substr($lastKode, 1) + 1 : 1;
        $kode = 'P' . str_pad($next, 3, '0', STR_PAD_LEFT);

        // logic store produk
        try {
            $produk = Produk::create([
                'kode_produk' => $kode,
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dibuat.',
                'data' => ProdukResource::collection([$produk])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat produk, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // logic find produk
        $produk = Produk::find($id);

        if ($produk == null) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk ditemukan.',
            'data' => new ProdukResource($produk)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:500',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ],
        [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists' => 'Kategori produk tidak ditemukan.',
            'satuan.required' => 'Satuan produk wajib diisi.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // logic find produk
        $produk = Produk::find($id);
        if ($produk == null) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // logic update produk
        try {
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui.',
                'data' => ProdukResource::collection([$produk])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui produk, silakan coba lagi.',
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // logic find produk
        $produk =  Produk::find($id);
        if ($produk == null) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // logic delete produk
        try {
            $produk->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk, silakan coba lagi.',
            ], 500);
        }
    }
}
