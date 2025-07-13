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
        // Get penggunaan that doesn't have a tagihan yet
        $penggunaan = Penggunaan::whereDoesntHave('tagihan')->first();
        
        if (!$penggunaan) {
            return redirect()->back()->with('error', 'Tidak ada data penggunaan yang perlu dibuatkan tagihan');
        }

        // Calculate jumlah_meter
        $jumlah_meter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

        // Create tagihan
        $tagihan = new Tagihan();
        $tagihan->pelanggan_id = $penggunaan->pelanggan_id;
        $tagihan->penggunaan_id = $penggunaan->id;
        $tagihan->jumlah_meter = $jumlah_meter;
        $tagihan->status = 0;
        $tagihan->save();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibuat');
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
        $tagihan = $pelanggan->tagihan()->with(['penggunaan', 'pembayaran'])->get();
        return view('tagihan.pelanggan', compact('pelanggan', 'tagihan'));
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
