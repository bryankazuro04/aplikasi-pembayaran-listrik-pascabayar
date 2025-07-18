<?php

namespace App\Http\Controllers;

use App\Models\tarif;
use App\Http\Requests\StoretarifRequest;
use App\Http\Requests\UpdatetarifRequest;
use Illuminate\Support\Facades\DB;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tarifs = tarif::withCount('pelanggan')->get();
        } catch (\Exception $e) {
            // Jika terjadi error, ambil data tarif tanpa relasi
            $tarifs = tarif::all();
            // Set pelanggan_count ke 0 untuk setiap tarif
            $tarifs->each(function ($tarif) {
                $tarif->pelanggan_count = 0;
            });
        }
        return view('admin.tarif', compact('tarifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretarifRequest $request)
    {
        try {
            DB::beginTransaction();
            
            tarif::create([
                'daya' => $request->daya,
                'tarif_per_kwh' => $request->tarifperkwh,
                'biaya_admin' => $request->biaya_admin
            ]);
            
            DB::commit();
            return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tarif.index')->with('error', 'Gagal menambahkan tarif');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(tarif $tarif)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tarif $tarif)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetarifRequest $request, tarif $tarif)
    {
        $tarif::where('id', $tarif->id)->update($request->validated());
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tarif $tarif)
    {
        try {
            DB::beginTransaction();
            
            // Cek apakah tarif memiliki pelanggan
            if ($tarif->pelanggan()->exists()) {
                return redirect()->route('tarif.index')
                    ->with('error', 'Tidak dapat menghapus tarif yang masih digunakan oleh pelanggan');
            }
            
            $tarif->delete();
            
            DB::commit();
            return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tarif.index')->with('error', 'Gagal menghapus tarif');
        }
    }
}
