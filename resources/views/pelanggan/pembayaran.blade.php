@extends('layouts.app')

@section('main')
    <h1 class="text-2xl font-bold mb-6">Konfirmasi Pembayaran</h1>

    <div class="bg-gray-50 p-6 rounded-lg border">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Detail Tagihan</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama Pelanggan</p>
                <p class="font-medium">{{ $tagihan->pelanggan->nama_pelanggan }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nomor KWH</p>
                <p class="font-medium">{{ $tagihan->pelanggan->nomor_kwh }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Periode</p>
                <p class="font-medium">{{ date('F Y', strtotime($tagihan->tahun . '-' . $tagihan->bulan)) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumlah Penggunaan</p>
                <p class="font-medium">{{ $tagihan->jumlah_meter }} kWh</p>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-4">
            <div class="flex justify-between items-center">
                <p class="text-gray-600">Tagihan Pemakaian</p>
                <p class="font-medium">Rp {{ number_format($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarif_per_kwh, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-between items-center mt-2">
                <p class="text-gray-600">Biaya Admin</p>
                <p class="font-medium">Rp {{ number_format($biaya_admin, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-between items-center mt-4 border-t pt-4">
                <p class="text-xl font-bold">Total Bayar</p>
                <p class="text-xl font-bold text-blue-600">Rp {{ number_format($total_bayar, 0, ',', '.') }}</p>
            </div>
        </div>

        <form action="{{ route('pembayaran.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="id" value="{{ $tagihan->id }}"> <input type="hidden" name="biaya_admin" value="{{ $biaya_admin }}"> <button type="submit" class="w-full bg-green-500 text-white text-lg font-bold py-3 rounded-lg hover:bg-green-600 transition duration-300">
                Konfirmasi dan Bayar
            </button>
        </form>
    </div>
@endsection