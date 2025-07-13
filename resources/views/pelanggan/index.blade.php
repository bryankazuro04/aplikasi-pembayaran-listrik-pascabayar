@extends('layouts.app')

@section('main')
  <div class="p-4 sm:p-6 w-full">
    <!-- Informasi Pelanggan -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Informasi Pelanggan</h2>
          <p class="text-sm text-gray-600 mt-1">Detail informasi pelanggan dan penggunaan listrik</p>
        </div>
        <div class="mt-4 sm:mt-0 text-right">
          <p class="text-sm text-gray-600">No. Meter:</p>
          <p class="text-lg font-semibold text-gray-800">{{ $pelanggan->nomor_meter ?? '-' }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-600">Nama Pelanggan</h3>
          <p class="text-lg font-semibold text-gray-800 mt-1">{{ $pelanggan->nama_pelanggan ?? '-' }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-600">Daya Terpasang</h3>
          <p class="text-lg font-semibold text-gray-800 mt-1">{{ number_format($pelanggan->tarif->daya ?? 0) }} VA</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-600">Tarif per kWh</h3>
          <p class="text-lg font-semibold text-gray-800 mt-1">Rp {{ number_format($pelanggan->tarif->tarifperkwh ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
          <h3 class="text-sm font-medium text-gray-600">Alamat</h3>
          <p class="text-sm text-gray-800 mt-1">{{ $pelanggan->alamat ?? '-' }}</p>
        </div>
      </div>
    </div>

    <!-- Ringkasan Tagihan -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
      <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Tagihan</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-6 rounded-lg text-white">
          <h3 class="text-base font-medium text-blue-700 mb-1">Total Tagihan</h3>
          <p class="text-3xl font-bold text-blue-800">Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</p>
          @if(($tagihanBelumLunas ?? 0) > 0)
            <p class="text-sm text-blue-800 mt-2">{{ $tagihanBelumLunas }} tagihan belum dibayar</p>
          @endif
        </div>

        <div class="bg-green-50 p-6 rounded-lg text-white">
          <h3 class="text-base font-medium text-emerald-700 mb-1">Penggunaan Bulan Ini</h3>
          <p class="text-3xl font-bold text-emerald-800">{{ number_format($penggunaanBulanIni ?? 0) }} kWh</p>
          <p class="text-sm text-emerald-800 mt-2">Periode {{ date('F Y') }}</p>
        </div>

        <div class="bg-purple-50 p-6 rounded-lg text-white">
          <h3 class="text-base font-medium text-violet-700 mb-1">Status Pembayaran</h3>
          <p class="text-2xl font-bold text-violet-800">{{ $status ?? 'Belum ada tagihan' }}</p>
          @if($jatuhTempo ?? false)
            <p class="text-sm text-violet-800 mt-2">Jatuh tempo: {{ $jatuhTempo }}</p>
          @endif
        </div>
      </div>

      <!-- Riwayat Tagihan -->
      <div class="overflow-x-auto">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Tagihan</h3>
        <div class="inline-block min-w-full align-middle">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meter Awal</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meter Akhir</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemakaian</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tagihan</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($tagihan ?? [] as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $t->bulan }} {{ $t->tahun }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                    {{ number_format($t->penggunaan->meter_awal) }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                    {{ number_format($t->penggunaan->meter_akhir) }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                    {{ number_format($t->penggunaan->meter_akhir - $t->penggunaan->meter_awal) }} kWh
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                    Rp {{ number_format($t->jumlah_meter * $t->pelanggan->tarif->tarifperkwh, 0, ',', '.') }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    @if($t->status_pembayaran)
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Lunas
                      </span>
                    @else
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3"/>
                        </svg>
                        Belum Lunas
                      </span>
                    @endif
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm">
                    @if(!$t->status_pembayaran)
                      <a href="{{ route('pembayaran.create', ['tagihan' => $t->id]) }}"
                         class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Bayar
                      </a>
                    @else
                      <a href="{{ route('pembayaran.show', ['tagihan' => $t->id]) }}"
                         class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail
                      </a>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm font-medium">Belum ada data tagihan</p>
                    <p class="mt-1 text-sm text-gray-500">Tagihan listrik Anda akan muncul di sini setiap bulan</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
