@extends('layouts.app')

@section('main')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Tagihan Listrik</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('tagihan.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <button onclick="window.print()" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Tagihan Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header Tagihan -->
            <div class="bg-blue-600 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">PT. LISTRIK NEGARA</h2>
                        <p class="text-blue-100">Tagihan Listrik Bulanan</p>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100">No. Tagihan</p>
                        <p class="text-xl font-bold">{{ str_pad($tagihan->id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Pembayaran -->
            <div class="px-6 py-4 {{ $tagihan->status_pembayaran == 1 ? 'bg-green-50 border-l-4 border-green-400' : 'bg-red-50 border-l-4 border-red-400' }}">
                <div class="flex items-center">
                    @if($tagihan->status_pembayaran == 1)
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-800 font-semibold">LUNAS</span>
                    @else
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-red-800 font-semibold">BELUM LUNAS</span>
                    @endif
                </div>
            </div>

            <!-- Informasi Pelanggan -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                        <p class="text-gray-900 font-semibold">{{ $tagihan->pelanggan->nama_pelanggan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Meter</label>
                        <p class="text-gray-900 font-semibold">{{ $tagihan->pelanggan->nomor_kwh }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $tagihan->pelanggan->alamat }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tarif</label>
                        <p class="text-gray-900">{{ $tagihan->pelanggan->tarif->daya }} VA</p>
                    </div>
                </div>
            </div>

            <!-- Detail Penggunaan -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Penggunaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                        <p class="text-gray-900 font-semibold">{{ $tagihan->bulan }}/{{ $tagihan->tahun }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Cek</label>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($tagihan->penggunaan->tanggal_cek)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meter Awal</label>
                        <p class="text-gray-900">{{ number_format($tagihan->penggunaan->meter_awal, 0, ',', '.') }} kWh</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meter Akhir</label>
                        <p class="text-gray-900">{{ number_format($tagihan->penggunaan->meter_akhir, 0, ',', '.') }} kWh</p>
                    </div>
                </div>
            </div>

            <!-- Perhitungan Tagihan -->
            <div class="p-6 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Perhitungan Tagihan</h3>
                
                @php
                    $tarif_perkwh = $tagihan->pelanggan->tarif->tarif_perkwh;
                    $total_tagihan = $tagihan->jumlah_meter * $tarif_perkwh;
                @endphp

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-700">Jumlah Penggunaan</span>
                        <span class="font-semibold">{{ number_format($tagihan->jumlah_meter, 0, ',', '.') }} kWh</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-700">Tarif per kWh</span>
                        <span class="font-semibold">Rp {{ number_format($tagihan->pelanggan->tarif->tarif_per_kwh, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-300 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($tagihan->pembayaran->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            @if($tagihan->pembayaran)
                <div class="p-6 bg-green-50 border-t border-green-200">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Informasi Pembayaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Tanggal Pembayaran</label>
                            <p class="text-green-900 font-semibold">{{ \Carbon\Carbon::parse($tagihan->pembayaran->tanggal_pembayaran)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Total Bayar</label>
                            <p class="text-green-900 font-semibold">Rp {{ number_format($tagihan->pembayaran->total_bayar, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="p-6 bg-white border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">
                        Tagihan dibuat pada: {{ $tagihan->created_at->format('d/m/Y H:i') }}
                    </p>
                    @if($tagihan->status_pembayaran == 0)
                        <a href="{{ route('pembayaran.create', ['id' => $tagihan->id]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 12px;
    }
    
    .container {
        max-width: none;
        margin: 0;
        padding: 0;
    }
}
</style>
@endsection