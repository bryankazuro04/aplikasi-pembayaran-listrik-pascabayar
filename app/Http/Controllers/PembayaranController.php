<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Models\pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = pembayaran::with(['tagihan.pelanggan'])->get();
        return view('admin.pembayaran', compact('pembayaran'));
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
        $tagihan = tagihan::with('pelanggan.tarif')->findOrFail($request->id);

        $jumlah_meter = $tagihan->jumlah_meter;
        $tarif_per_kwh = $tagihan->pelanggan->tarif->tarif_per_kwh;
        $biaya_admin = $request->biaya_admin;
        $total_bayar = $jumlah_meter * $tarif_per_kwh + $biaya_admin;

        Pembayaran::create([
            'id_tagihan' => $tagihan->id,
            'id_pelanggan' => $tagihan->id_pelanggan,
            'tanggal_pembayaran' => now(),
            'bulan' => now()->month,
            'biaya_admin' => $biaya_admin,
            'total_bayar' => $total_bayar,
        ]);

        $tagihan->update(['status_pembayaran' => 1]);

        return redirect()->route('pelanggan.home')->with('success', 'Pembayaran berhasil dilakukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tagihan = tagihan::with(['penggunaan', 'pelanggan.tarif'])->findOrFail($id);

        $jumlah_meter = $tagihan->jumlah_meter;
        $tarif_per_kwh = $tagihan->pelanggan->tarif->tarif_per_kwh;
        $biaya_admin = 2500;

        $total_bayar = $jumlah_meter * $tarif_per_kwh + $biaya_admin;

        return view('pelanggan.pembayaran', compact('tagihan', 'total_bayar', 'biaya_admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(404);
    }
}
