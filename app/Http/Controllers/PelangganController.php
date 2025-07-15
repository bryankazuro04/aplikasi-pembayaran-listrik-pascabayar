<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Http\Requests\StorepelangganRequest;
use App\Http\Requests\UpdatepelangganRequest;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = pelanggan::with(['tarif', 'tagihan', 'pembayaran'])->get();
        $tarifs = \App\Models\tarif::all();

        return view('admin.pelanggan.pelanggan', compact('pelanggan', 'tarifs'));
    }

    /**
     * Display for the pelanggan home page.
     */
    public function home()
    {
        $pelanggan = auth()
            ->guard('pelanggan')
            ->user()
            ->load(['penggunaan', 'tarif', 'tagihan', 'pembayaran']);

        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        $penggunaanBulanIni = $pelanggan->penggunaan->where('bulan', $currentMonth)->where('tahun', $currentYear)->first();

        if ($penggunaanBulanIni) {
            $jumlahMeter = $penggunaanBulanIni->meter_akhir - $penggunaanBulanIni->meter_awal;
            $tarifPerKwh = $pelanggan->tarif->tarif_per_kwh ?? 0;
            $biayaAdmin = 2500;
            $totalTagihan = $jumlahMeter * $tarifPerKwh + $biayaAdmin;
        } else {
            $totalTagihan = 0;
        }
        return view('pelanggan.index', compact('pelanggan', 'totalTagihan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tarif = \App\Models\tarif::all();
        return view('admin.pelanggan.create', compact('tarif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepelangganRequest $request)
    {
        $validatedData = $request->validated();
        
        // Hash password
        $validatedData['password'] = bcrypt($validatedData['password']);
        
        pelanggan::create($validatedData);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return abort(404);
    }

    /**
     * Search for a pelanggan by nomor_kwh or nama_pelanggan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q');

            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }

            $pelanggan = pelanggan::searchByNomorKwh($query);

            return response()->json(
                $pelanggan->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nomor_kwh' => $item->nomor_kwh,
                        'nama_pelanggan' => $item->nama_pelanggan,
                    ];
                }),
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mencari pelanggan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pelanggan $pelanggan)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepelangganRequest $request, pelanggan $pelanggan)
    {
        $pelanggan->update($request->validated());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pelanggan $pelanggan)
    {
        pelanggan::destroy($pelanggan->id);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
