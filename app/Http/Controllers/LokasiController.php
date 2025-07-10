<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = Lokasi::orderBy('created_at', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Daftar lokasi berhasil diambil.',
            'data' => $lokasi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required|string|max:255|unique:lokasi,nama_lokasi',
            'penanggung_jawab' => 'nullable|string|max:255',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.string' => 'Nama lokasi harus berupa string.',
            'nama_lokasi.max' => 'Nama lokasi maksimal 255 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi sudah ada, silakan gunakan nama lain.',
            'penanggung_jawab.string' => 'Penanggung jawab harus berupa string.',
            'penanggung_jawab.max' => 'Penanggung jawab maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate kode_lokasi
        $lastKode = Lokasi::orderBy('kode_lokasi', 'desc')->value('kode_lokasi');
        $next = $lastKode ? (int)substr($lastKode, 1) + 1 : 1;
        $kode = 'L' . str_pad($next, 3, '0', STR_PAD_LEFT);

        // logic store lokasi
        try {
            $lokasi = Lokasi::create([
                'kode_lokasi' => $kode,
                'nama_lokasi' => $request->nama_lokasi,
                'penanggung_jawab' => $request->penanggung_jawab,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Lokasi berhasil ditambahkan.',
                'data' => $lokasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan lokasi, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // logic find lokasi
        $lokasi = Lokasi::find($id);

        if ($lokasi == null) {
            return response()->json([
                'status' => false,
                'message' => 'Data lokasi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data lokasi ditemukan.',
            'data' => $lokasi
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required|string|max:255|unique:lokasi,nama_lokasi,' . $id,
            'penanggung_jawab' => 'nullable|string|max:255',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.string' => 'Nama lokasi harus berupa string.',
            'nama_lokasi.max' => 'Nama lokasi maksimal 255 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi sudah ada, silakan gunakan nama lain.',
            'penanggung_jawab.string' => 'Penanggung jawab harus berupa string.',
            'penanggung_jawab.max' => 'Penanggung jawab maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // logic find lokasi
        $lokasi = Lokasi::find($id);
        if ($lokasi == null) {
            return response()->json([
                'status' => false,
                'message' => 'Data lokasi tidak ditemukan.',
            ], 404);
        }

        // logic update lokasi
        try {
            $lokasi->update([
                'nama_lokasi' => $request->nama_lokasi,
                'penanggung_jawab' => $request->penanggung_jawab,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data lokasi berhasil diperbarui.',
                'data' => $lokasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui lokasi, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // logic find lokasi
        $lokasi = Lokasi::find($id);
        if ($lokasi == null) {
            return response()->json([
                'status' => false,
                'message' => 'Data lokasi tidak ditemukan.',
            ], 404);
        }

        // Cek apakah lokasi masih digunakan oleh produk
        if ($lokasi->produkLokasi()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Lokasi tidak dapat dihapus karena masih digunakan oleh produk.',
            ], 400);
        }

        // logic delete lokasi
        try {
            $lokasi->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data lokasi berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus lokasi, silakan coba lagi.',
            ], 500);
        }
    }
}
