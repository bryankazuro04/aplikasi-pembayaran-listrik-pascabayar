<?php

namespace App\Http\Controllers;

use App\Models\penggunaan;
use App\Http\Requests\StorepenggunaanRequest;
use App\Http\Requests\UpdatepenggunaanRequest;
use App\Models\pelanggan;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunaans = penggunaan::with(['pelanggan'])->get();
        return view('admin.penggunaan.index', compact('penggunaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = pelanggan::all();
        return view('admin.penggunaan.create', compact('pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepenggunaanRequest $request)
    {
        penggunaan::create($request->validated());
        return redirect()->route('penggunaan.index')->with('success', 'Penggunaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(penggunaan $penggunaan)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penggunaan $penggunaan)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepenggunaanRequest $request, penggunaan $penggunaan)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penggunaan $penggunaan)
    {
        return abort(404);
    }
}
