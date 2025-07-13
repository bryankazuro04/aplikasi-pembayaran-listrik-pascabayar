<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Http\Requests\StorepelangganRequest;
use App\Http\Requests\UpdatepelangganRequest;
use App\Models\tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $pelanggan = auth()->guard('pelanggan')->user()->load(['penggunaan', 'tarif', 'tagihan', 'pembayaran']);
        // return view('pelanggan.index', compact('pelanggan'));
        $pelanggan = pelanggan::with(['tarif', 'tagihan', 'pembayaran'])->get();
        $tarifs = \App\Models\tarif::all();
        return view('admin.pelanggan', compact('pelanggan', 'tarifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tarif = \App\Models\tarif::all();
        return view('pelanggan.create', compact('tarif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepelangganRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->password),
        ]);
        pelanggan::create($request->validated());
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Search for a pelanggan by nomor_kwh or nama_pelanggan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        if(empty($query)) {
            return response()->json([]);
        }

        $pelanggan = pelanggan::searchByNomorKwh($query);

        return response()->json($pelanggan->map(function($item) {
            return [
                'id' => $item->id,
                'nomor_kwh' => $item->nomor_kwh,
                'nama_pelanggan' => $item->nama_pelanggan,
            ];
        }));
    }

    public function getByNomorKwh(Request $request)
    {
        $nomorKwh = $request->get('nomor_kwh');

        $pelanggan = pelanggan::where('nomor_kwh', $nomorKwh)->first();

        if($pelanggan) {
            return response()->json([
                'success' => true,
                'data' => $pelanggan
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pelanggan tidak ditemukan'
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pelanggan $pelanggan)
    {
        //
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
