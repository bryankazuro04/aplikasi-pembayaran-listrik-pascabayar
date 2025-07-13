<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::with(['tagihan.pelanggan'])->get();
        return view('admin.pembayaran', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tagihan = Tagihan::with(['penggunaan', 'pelanggan.tarif'])->findOrFail($id);

        $jumlah_meter = $tagihan->jumlah_meter;
        $tarif_per_kwh = $tagihan->pelanggan->tarif->tarif_per_kwh;
        $biaya_admin = 2500;

        $total_bayar = $jumlah_meter * $tarif_per_kwh + $biaya_admin;

        return view('pembayaran.create', compact('tagihan', 'total_bayar', 'biaya_admin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tagihan = Tagihan::with('pelanggan.tarif')->findOrFail($request->id);

        $jumlah_meter = $tagihan->jumlah_meter;
        $tarif_per_kwh = $tagihan->pelanggan->tarif->tarif_per_kwh;
        $biaya_admin = $request->biaya_admin;
        $total_bayar = $jumlah_meter * $tarif_per_kwh + $biaya_admin;

        Pembayaran::create([
            'id_tagihan' => $tagihan->id,
            'id_pelanggan' => $tagihan->id_pelanggan,
            'biaya_admin' => $biaya_admin,
            'total_bayar' => $total_bayar,
            'tanggal_pembayaran' => now(),
            'bulan_bayar' => $tagihan->bulan,
        ]);

        $tagihan->update(['status_pembayaran' => 1]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dilakukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $pembayaran = Pembayaran::with(['tagihan.pelanggan.tarif', 'tagihan.penggunaan'])->findOrFail($id);
        // return view('pelanggan.detail-pembayaran', compact('pembayaran'));
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
