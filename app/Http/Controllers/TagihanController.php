<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagihan = Tagihan::with(['pelanggan', 'penggunaan'])->get();
        return view('pelanggan.tagihan', compact('tagihan'));
    }

    /**
     * Show the form for creating a new resource.
     * Langsung membuat tagihan berdasarkan penggunaan_id
     */
    public function create(Request $request)
    {
        $penggunaan_id = $request->get('penggunaan_id');
        
        if (!$penggunaan_id) {
            return redirect()->back()->with('error', 'ID Penggunaan tidak ditemukan');
        }

        $penggunaan = Penggunaan::with(['pelanggan.tarif'])->findOrFail($penggunaan_id);
        
        // Check if tagihan already exists for this penggunaan
        $existingTagihan = Tagihan::where('id_penggunaan', $penggunaan_id)->first();
        if ($existingTagihan) {
            return redirect()->route('penggunaan.index', $existingTagihan->id)
                ->with('info', 'Tagihan untuk periode ini sudah dibuat sebelumnya');
        }

        try {
            DB::beginTransaction();

            $jumlah_meter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

            $tagihan = Tagihan::create([
                'id_penggunaan' => $penggunaan->id,
                'id_pelanggan' => $penggunaan->id_pelanggan,
                'bulan' => $penggunaan->bulan,
                'tahun' => $penggunaan->tahun,
                'jumlah_meter' => $jumlah_meter,
                'status_pembayaran' => 0, // Belum dibayar
            ]);

            DB::commit();

            return redirect()->route('penggunaan.index', $tagihan->id)
                ->with('success', 'Tagihan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Method ini tidak digunakan karena create langsung membuat tagihan
        return redirect()->back()->with('error', 'Method tidak diizinkan');
    }

    /**
     * Display the specified resource.
     * Menampilkan tagihan sebagai acuan pembayaran
     */
    public function show(Tagihan $tagihan)
    {
        $tagihan->load(['pelanggan.tarif', 'penggunaan', 'pembayaran']);
        return view('pelanggan.tagihan.show', compact('tagihan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihan)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihan)
    {
        //
    }
}