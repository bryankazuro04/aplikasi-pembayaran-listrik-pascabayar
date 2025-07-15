<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Models\pembayaran;
use App\Models\tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // --- Data untuk Kartu Statistik ---

        // 1. Total Pelanggan (Asumsi level_id untuk pelanggan adalah 2)
        $totalPelanggan = pelanggan::count();

        // 2. Total Pembayaran Bulan Ini
        $pembayaranBulanIni = pembayaran::whereYear('tanggal_pembayaran', now()->year)->whereMonth('tanggal_pembayaran', now()->month)->sum('total_bayar');

        // 3. Jumlah Tagihan yang Belum Lunas
        $tagihanBelumLunas = tagihan::where('status_pembayaran', false)->count();

        // --- Data untuk Tabel Tagihan Terbaru ---
        $tagihanTerbaru = tagihan::with(['pelanggan', 'penggunaan'])
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->limit(5)
            ->get();

        // --- Data untuk Grafik ---

        // 1. Grafik Batang: Pembayaran per Bulan (6 bulan terakhir)
        $pembayaranPerBulan = pembayaran::select(DB::raw('YEAR(tanggal_pembayaran) as tahun'), DB::raw('MONTH(tanggal_pembayaran) as bulan'), DB::raw('SUM(total_bayar) as total'))
            ->where('tanggal_pembayaran', '>=', Carbon::now()->subMonths(6))
            ->groupBy(DB::raw('YEAR(tanggal_pembayaran)'), DB::raw('MONTH(tanggal_pembayaran)'))
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $bulanLabels = $pembayaranPerBulan->map(function ($item) {
            return Carbon::create()->month($item->bulan)->format('M') . ' ' . $item->tahun;
        });
        $totalPembayaranPerBulan = $pembayaranPerBulan->pluck('total');

        // 2. Grafik Donat: Status Tagihan
        $tagihanLunas = tagihan::where('status_pembayaran', true)->count();
        // Variabel $tagihanBelumLunas sudah dihitung di atas

        // Mengirim semua data ke view
        return view('dashboard', [
            'totalPelanggan' => $totalPelanggan,
            'pembayaranBulanIni' => $pembayaranBulanIni,
            'tagihanBelumLunas' => $tagihanBelumLunas,
            'tagihanTerbaru' => $tagihanTerbaru,
            'bulan' => $bulanLabels,
            'totalPembayaranPerBulan' => $totalPembayaranPerBulan,
            'tagihanLunas' => $tagihanLunas,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
