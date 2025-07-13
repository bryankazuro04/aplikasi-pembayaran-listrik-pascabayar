<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
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
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tagihan $tagihan)
    {
        // Pastikan tagihan belum dibayar
        if ($tagihan->status_pembayaran) {
            return redirect()->route('pelanggan.index')
                ->with('error', 'Tagihan ini sudah dibayar');
        }

        return view('pelanggan.pembayaran', compact('tagihan'));
    }

    /**
     * Proses pembayaran tagihan
     */
    public function store(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'bank' => 'required|in:bca,mandiri,bni,bri',
            'nomor_rekening' => 'required|string|max:20',
            'nama_rekening' => 'required|string|max:100',
            'jumlah_bayar' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $tagihan = Tagihan::findOrFail($request->tagihan_id);
            
            // Cek status pembayaran
            if ($tagihan->status_pembayaran) {
                throw new \Exception('Tagihan ini sudah dibayar');
            }

            // Hitung total tagihan
            $totalTagihan = $tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh;
            
            // Validasi jumlah pembayaran
            if ($request->jumlah_bayar != $totalTagihan) {
                throw new \Exception('Jumlah pembayaran tidak sesuai dengan tagihan');
            }

            // Buat record pembayaran
            $pembayaran = new Pembayaran();
            $pembayaran->tagihan_id = $tagihan->id;
            $pembayaran->tanggal_pembayaran = now();
            $pembayaran->bulan_bayar = $tagihan->bulan;
            $pembayaran->tahun_bayar = $tagihan->tahun;
            $pembayaran->biaya_admin = 2500; // Biaya admin tetap
            $pembayaran->total_bayar = $totalTagihan + $pembayaran->biaya_admin;
            $pembayaran->status = 'LUNAS';
            $pembayaran->bank = $request->bank;
            $pembayaran->nomor_rekening = $request->nomor_rekening;
            $pembayaran->nama_rekening = $request->nama_rekening;
            $pembayaran->save();

            // Update status tagihan
            $tagihan->status_pembayaran = true;
            $tagihan->save();

            DB::commit();

            // Redirect ke halaman detail pembayaran
            return redirect()->route('pembayaran.show', ['tagihan' => $tagihan->id])
                ->with('success', 'Pembayaran berhasil diproses');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Display bukti pembayaran
     */
    public function show(Tagihan $tagihan)
    {
        $pembayaran = $tagihan->pembayaran;
        if (!$pembayaran) {
            return redirect()->route('pelanggan.index')
                ->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('pelanggan.detail-pembayaran', compact('pembayaran', 'tagihan'));
    }

    /**
     * Konfirmasi pembayaran (untuk admin)
     */
    public function konfirmasi(Pembayaran $pembayaran)
    {
        $pembayaran->status = 'TERKONFIRMASI';
        $pembayaran->save();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        return redirect()->route('pembayaran.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        return redirect()->route('pembayaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        return redirect()->route('pembayaran.index');
    }
}
