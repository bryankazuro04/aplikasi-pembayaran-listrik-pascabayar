@extends('layouts.app')

@section('main')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Konfirmasi Pembayaran</h1>
        <p class="text-gray-600 mt-2">Satu langkah lagi untuk menyelesaikan tagihan Anda. Mohon periksa kembali detail di bawah ini.</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 md:p-8">
            
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Detail Tagihan</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Nama Pelanggan</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $tagihan->pelanggan->nama_pelanggan }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Nomor KWH</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $tagihan->pelanggan->nomor_kwh }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Periode Tagihan</span>
                    <span class="font-semibold text-gray-800 text-right">{{ date('F Y', strtotime($tagihan->tahun . '-' . $tagihan->bulan)) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Jumlah Penggunaan</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $tagihan->jumlah_meter }} kWh</span>
                </div>
            </div>

            <hr class="my-6">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">Rincian Biaya</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Tagihan Pemakaian</span>
                    {{-- Saran: Sebaiknya hasil perkalian ini dihitung di Controller dan dilempar sebagai variabel tunggal --}}
                    <span class="font-medium">Rp {{ number_format($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarif_per_kwh, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Biaya Admin</span>
                    <span class="font-medium">Rp {{ number_format($biaya_admin, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t-2 border-dashed">
                <span class="text-xl font-bold text-gray-800">Total Bayar</span>
                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
            </div>
            
        </div>

        <div class="bg-gray-50 p-6">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $tagihan->id }}">
                <input type="hidden" name="biaya_admin" value="{{ $biaya_admin }}">
                
                <button type="submit" class="w-full flex items-center justify-center bg-green-500 text-white text-lg font-bold py-3 px-6 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Konfirmasi dan Bayar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection