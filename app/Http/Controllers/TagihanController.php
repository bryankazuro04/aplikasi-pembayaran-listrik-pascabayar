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
        return view('admin.tagihan.index', compact('tagihan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $penggunaan = Penggunaan::whereDoesntHave('tagihan')->get();
        return view('admin.tagihan.create', compact('pelanggan', 'penggunaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penggunaan_id' => 'required|exists:penggunaans,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $penggunaan = Penggunaan::with('pelanggan.tarif')->findOrFail($request->penggunaan_id);
            
            // Hitung jumlah meter
            $jumlahMeter = $penggunaan->meter_akhir - $penggunaan->meter_awal;
            
            // Buat tagihan baru
            $tagihan = new Tagihan();
            $tagihan->penggunaan_id = $penggunaan->id;
            $tagihan->pelanggan_id = $penggunaan->pelanggan_id;
            $tagihan->bulan = $request->bulan;
            $tagihan->tahun = $request->tahun;
            $tagihan->jumlah_meter = $jumlahMeter;
            $tagihan->status_pembayaran = false;
            $tagihan->save();

            DB::commit();
            return redirect()->route('tagihan.index')
                ->with('success', 'Tagihan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal membuat tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $tagihan)
    {
        $tagihan->load(['pelanggan.tarif', 'penggunaan', 'pembayaran']);
        return view('admin.tagihan.show', compact('tagihan'));
    }

    /**
     * Display tagihan for specific pelanggan
     */
    public function tagihanPelanggan(Pelanggan $pelanggan)
    {
        $tagihan = Tagihan::with(['penggunaan', 'pembayaran'])
            ->where('pelanggan_id', $pelanggan->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $totalTagihan = $tagihan->where('status_pembayaran', false)
            ->sum(function ($t) {
                return $t->jumlah_meter * $t->pelanggan->tarif->tarifperkwh;
            });

        $tagihanBelumLunas = $tagihan->where('status_pembayaran', false)->count();
        
        $penggunaanBulanIni = $tagihan->first()->penggunaan->meter_akhir - $tagihan->first()->penggunaan->meter_awal ?? 0;
        
        $status = $tagihanBelumLunas > 0 ? 'Belum Lunas' : 'Lunas';
        
        return view('pelanggan.index', compact(
            'tagihan', 
            'totalTagihan', 
            'tagihanBelumLunas', 
            'penggunaanBulanIni',
            'status'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihan)
    {
        $tagihan->load(['pelanggan', 'penggunaan']);
        return view('admin.tagihan.edit', compact('tagihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        try {
            $tagihan->bulan = $request->bulan;
            $tagihan->tahun = $request->tahun;
            $tagihan->save();

            return redirect()->route('tagihan.index')
                ->with('success', 'Tagihan berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihan)
    {
        if ($tagihan->status_pembayaran) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus tagihan yang sudah dibayar');
        }

        try {
            $tagihan->delete();
            return redirect()->route('tagihan.index')
                ->with('success', 'Tagihan berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus tagihan: ' . $e->getMessage());
        }
    }
}
