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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $penggunaan = Penggunaan::findOrFail($request->id);

        $jumlah_meter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

        $tagihan = Tagihan::create([
            'id_penggunaan' => $penggunaan->id,
            'id_pelanggan' => $penggunaan->id_pelanggan,
            'bulan' => $penggunaan->bulan,
            'tahun' => $penggunaan->tahun,
            'jumlah_meter' => $jumlah_meter,
            'status_pembayaran' => 0, // Belum dibayar
        ]);

        return redirect()->route('pembayaran.create', ['id' => $tagihan->id]);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihan)
    {
        // $tagihan->load(['pelanggan', 'penggunaan']);
        // return view('admin.tagihan.edit', compact('tagihan'));
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
