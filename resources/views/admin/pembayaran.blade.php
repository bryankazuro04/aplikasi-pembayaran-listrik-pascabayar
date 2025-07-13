@extends('layouts.app')

@section('main')
<div class="p-4 sm:p-6 w-full bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pembayaran Tagihan</h1>
            <p class="text-gray-600 mt-2">Kelola dan proses pembayaran tagihan listrik pelanggan</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center mb-4">
                <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Pencarian Tagihan</h2>
            </div>
            
            <form action="" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="nomor_meter" class="block text-sm font-medium text-gray-700">Nomor Meter</label>
                        <div class="relative">
                            <input type="text" name="nomor_meter" id="nomor_meter" 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Cari nomor meter..." value="{{ request('nomor_meter') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <div class="relative">
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Cari nama pelanggan..." value="{{ request('nama_pelanggan') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium shadow-sm">
                            <svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari Tagihan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if(isset($tagihan))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Bill Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800">Detail Tagihan</h3>
                        </div>
                        @if($tagihan->status == 'lunas')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Belum Lunas
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Nomor Tagihan</p>
                                <p class="text-lg font-semibold text-gray-900">#{{ str_pad($tagihan->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Nama Pelanggan</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $tagihan->pelanggan->nama_pelanggan }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pemakaian</p>
                                <p class="text-lg font-semibold text-gray-900">{{ number_format($tagihan->jumlah_meter) }} kWh</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Periode Tagihan</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Nomor Meter</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $tagihan->pelanggan->nomor_meter }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                <p class="text-sm font-medium text-blue-700 mb-1">Total Tagihan</p>
                                <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="lg:col-span-1">
                @if($tagihan->status != 'lunas')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <svg class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800">Proses Pembayaran</h3>
                    </div>

                    <form action="{{ route('admin.pembayaran.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                        
                        <div>
                            <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select id="metode_pembayaran" name="metode_pembayaran" class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="tunai">💵 Tunai</option>
                                <option value="transfer">🏦 Transfer Bank</option>
                                <option value="kartu_kredit">💳 Kartu Kredit</option>
                                <option value="e_wallet">📱 E-Wallet</option>
                            </select>
                        </div>

                        <div>
                            <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pembayaran</label>
                            <input type="date" name="tanggal_bayar" id="tanggal_bayar" 
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                value="{{ date('Y-m-d') }}">
                        </div>

                        <div>
                            <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pembayaran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm font-medium">Rp</span>
                                </div>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" 
                                    class="block w-full pl-12 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                    value="{{ $tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh }}"
                                    min="0" step="1">
                            </div>
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" 
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                placeholder="Keterangan pembayaran (opsional)"></textarea>
                        </div>

                        <div>
                            <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-2">Admin</label>
                            <input type="text" name="admin_name" id="admin_name" 
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                                value="{{ auth()->user()->name }}" readonly>
                            <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">
                        </div>

                        <div class="pt-4 space-y-3">
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 font-medium shadow-sm">
                                <svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Konfirmasi Pembayaran
                            </button>
                            <a href="{{ route('admin.pembayaran.index') }}" class="w-full block text-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
                @else
                <!-- Already Paid -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tagihan Sudah Lunas</h3>
                        <p class="text-sm text-gray-500">Tagihan ini telah dibayar dan tidak memerlukan tindakan lebih lanjut.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if(!isset($tagihan) && (request('nomor_meter') || request('nama_pelanggan')))
        <!-- No Bill Found -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tagihan Tidak Ditemukan</h3>
                <p class="text-sm text-gray-500 mb-4">Tidak ada tagihan yang belum lunas ditemukan untuk kriteria pencarian tersebut.</p>
                <button onclick="document.querySelector('form').reset(); window.location.href = window.location.pathname;" class="text-blue-600 hover:text-blue-500 font-medium">
                    Coba pencarian lain
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection