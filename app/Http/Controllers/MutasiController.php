<?php

namespace App\Http\Controllers;

use App\Http\Resources\MutasiResource;
use App\Models\Mutasi;
use App\Models\ProdukLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasi = Mutasi::with(['produkLokasi', 'user'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar mutasi berhasil diambil.',
            'data' => MutasiResource::collection($mutasi),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date_format:Y-m-d',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
            'produk_lokasi_id' => 'required|exists:produk_lokasi,id',
        ], [
            'tanggal.required' => 'Tanggal mutasi wajib diisi.',
            'tanggal.date_format' => 'Format tanggal harus YYYY-MM-DD.',
            'jenis_mutasi.required' => 'Jenis mutasi wajib diisi.',
            'jenis_mutasi.in' => 'Jenis mutasi harus salah satu dari: masuk / keluar.',
            'jumlah.required' => 'Jumlah mutasi wajib diisi.',
            'jumlah.integer' => 'Jumlah mutasi harus berupa angka.',
            'jumlah.min' => 'Jumlah mutasi minimal 1.',
            'produk_lokasi_id.required' => 'Produk lokasi wajib dipilih.',
            'produk_lokasi_id.exists' => 'Produk lokasi tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal, periksa inputan anda.',
                'errors' => $validator->errors(),
            ], 422);
        }

        //logic store mutasi
        DB::beginTransaction();
        try {
            $produkLokasi = ProdukLokasi::findOrFail($request->produk_lokasi_id);

            //update stok produk lokasi
            if ($request->jenis_mutasi === 'masuk') {
                $produkLokasi->stok += $request->jumlah;
            } else {
                if ($produkLokasi->stok < $request->jumlah) {
                    return response()->json(['message' => 'Stok tidak mencukupi'], 400);
                } else {
                    $produkLokasi->stok -= $request->jumlah;
                }
            }

            $produkLokasi->save();

            //create mutasi record
            $mutasi = Mutasi::create([
                'tanggal' => $request->tanggal,
                'jenis_mutasi' => $request->jenis_mutasi,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'produk_lokasi_id' => $request->produk_lokasi_id,
                'user_id' => $request->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Mutasi berhasil dibuat.',
                'data' => new MutasiResource($mutasi),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //logic find mutasi
        $mutasi = Mutasi::with(['produkLokasi', 'user'])->find($id);
        if ($mutasi == null) {
            return response()->json([
                'status' => false,
                'message' => 'Data mutasi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data mutasi ditemukan.',
            'data' => new MutasiResource($mutasi),
        ], 200);
    }

    /**
     * Get mutasi by produk from storage.
     */
    public function historyByProduk($produkId)
    {
        // Ambil mutasi berdasarkan produk_id
        $mutasi = Mutasi::whereHas('produkLokasi', function ($q) use ($produkId) {
            $q->where('produk_id', $produkId);
        })->with(['user', 'produkLokasi.lokasi'])->get();

        // Cek apakah mutasi ditemukan
        if ($mutasi->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mutasi untuk produk ini.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daftar mutasi produk berhasil diambil.',
            'data' => MutasiResource::collection($mutasi),
        ], 200);
    }

    /**
     * Get mutasi by user from storage.
     */
    public function historyByUser($userId)
    {
        // Ambil mutasi berdasarkan user_id
        $mutasi = Mutasi::where('user_id', $userId)
            ->with(['produkLokasi', 'user'])
            ->get();

        // Cek apakah mutasi ditemukan
        if ($mutasi->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mutasi untuk pengguna ini.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daftar mutasi pengguna berhasil diambil.',
            'data' => MutasiResource::collection($mutasi),
        ], 200);
    }
}
