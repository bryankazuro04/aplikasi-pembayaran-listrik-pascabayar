{{-- not used --}}


@extends('layouts.app')

@section('main')
<div class="p-4 sm:p-6 w-full">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header -->
            <div class="border-b pb-4 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Pembayaran</h2>
                        <p class="text-sm text-gray-600 mt-1">Bukti pembayaran tagihan listrik</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            LUNAS
                        </span>
                        <p class="text-sm text-gray-500 mt-2">{{ $pembayaran->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelanggan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-4">Informasi Pelanggan</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Nama Pelanggan</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tagihan->pelanggan->nama_pelanggan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Nomor Meter</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tagihan->pelanggan->nomor_meter }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Alamat</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tagihan->pelanggan->alamat }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-4">Detail Pembayaran</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Nomor Pembayaran</dt>
                            <dd class="text-sm font-medium text-gray-900">#{{ str_pad($pembayaran->id, 8, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Metode Pembayaran</dt>
                            <dd class="text-sm font-medium text-gray-900">Bank {{ strtoupper($pembayaran->bank) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Tanggal Pembayaran</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $pembayaran->tanggal_pembayaran->format('d F Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Detail Tagihan -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Rincian Tagihan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Periode Tagihan</span>
                        <span class="text-sm font-medium text-gray-900">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Pemakaian</span>
                        <span class="text-sm font-medium text-gray-900">{{ number_format($tagihan->jumlah_meter) }} kWh</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tarif per kWh</span>
                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($tagihan->pelanggan->tarif->tarifperkwh, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Biaya Listrik</span>
                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Biaya Admin</span>
                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($pembayaran->biaya_admin, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-3 border-t">
                        <div class="flex justify-between">
                            <span class="text-base font-medium text-gray-900">Total Pembayaran</span>
                            <span class="text-base font-bold text-gray-900">Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center">
                <a href="{{ route('pelanggan.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
