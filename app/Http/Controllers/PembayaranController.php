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
    public function create()
    {
        $tagihan = Tagihan::where('status', 'belum_dibayar')
            ->with(['pelanggan.tarif', 'penggunaan'])
            ->get();
        return view('pembayaran.create', compact('tagihan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get unpaid tagihan
        $tagihan = Tagihan::where('status', 'belum_dibayar')
                         ->with('pelanggan.tarif')
                         ->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tidak ada tagihan yang perlu dibayar');
        }

        DB::beginTransaction();
        try {
            $biaya_admin = 2500; // Set fixed biaya_admin
            
            // Calculate total_bayar based on jumlah_meter × tarif_per_kwh + biaya_admin
            $total_bayar = ($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarif_per_kwh) + $biaya_admin;

            // Create pembayaran
            $pembayaran = new Pembayaran();
            $pembayaran->tagihan_id = $tagihan->id;
            $pembayaran->tanggal_pembayaran = now();
            $pembayaran->biaya_admin = $biaya_admin;
            $pembayaran->total_bayar = $total_bayar;
            $pembayaran->save();

            // Update tagihan status
            $tagihan->status = 'sudah_dibayar';
            $tagihan->save();

            DB::commit();
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diproses');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran = Pembayaran::with(['tagihan.pelanggan.tarif', 'tagihan.penggunaan'])->findOrFail($id);
        return view('pelanggan.detail-pembayaran', compact('pembayaran'));
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
