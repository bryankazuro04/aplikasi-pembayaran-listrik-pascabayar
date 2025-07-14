@extends('layouts.app')

@section('main')
  <div class="w-full p-4 sm:p-6">

    <!-- Informasi Pelanggan -->
    <div class="mb-6 rounded-lg bg-white p-6 shadow-lg">
      <div class="mb-6 flex flex-col items-start justify-between sm:flex-row sm:items-center">
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Informasi Pelanggan</h2>
          <p class="mt-1 text-sm text-gray-600">Detail informasi pelanggan dan penggunaan listrik</p>
        </div>
        <div class="mt-4 text-right sm:mt-0">
          <p class="text-sm text-gray-600">No. Meter:</p>
          <p class="text-lg font-semibold text-gray-800">{{ $pelanggan->nomor_kwh ?? '-' }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-lg bg-gray-50 p-4">
          <h3 class="text-sm font-medium text-gray-600">Nama Pelanggan</h3>
          <p class="mt-1 text-lg font-semibold text-gray-800">{{ $pelanggan->nama_pelanggan ?? '-' }}</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-4">
          <h3 class="text-sm font-medium text-gray-600">Daya Terpasang</h3>
          <p class="mt-1 text-lg font-semibold text-gray-800">{{ number_format($pelanggan->tarif->daya ?? 0) }} VA</p>
        </div>
        <div class="rounded-lg bg-gray-50 p-4">
          <h3 class="text-sm font-medium text-gray-600">Tarif per kWh</h3>
          <p class="mt-1 text-lg font-semibold text-gray-800">Rp
            {{ number_format($pelanggan->tarif->tarif_per_kwh ?? 0, 0, ',', '.') }}</p>
        </div>
      </div>

      <div class="rounded-lg bg-gray-50 p-4 mt-3">
        <h3 class="text-sm font-medium text-gray-600">Alamat</h3>
        <p class="mt-1 text-sm text-gray-800">{{ $pelanggan->alamat ?? '-' }}</p>
      </div>
    </div>

    <!-- Ringkasan Tagihan -->
    <div class="mb-6 rounded-lg bg-white p-6 shadow-lg">
      <h2 class="mb-6 text-xl font-bold text-gray-800">Ringkasan Tagihan</h2>

      <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-lg bg-blue-50 p-6 text-white">
          <h3 class="mb-1 text-base font-medium text-blue-700">Total Tagihan</h3>
          <p class="text-3xl font-bold text-blue-800">Rp
            {{ number_format($pelanggan->pembayaran->last()->total_bayar ?? 0, 0, ',', '.') }}</p>
          @if (($pelanggan->tagihan->last()->status ?? 0) > 0)
            <p class="mt-2 text-sm text-blue-800">{{ $pelanggan->tagihan->last()->status }} tagihan belum dibayar</p>
          @endif
        </div>

        <div class="rounded-lg bg-green-50 p-6 text-white">
          <h3 class="mb-1 text-base font-medium text-emerald-700">Penggunaan Bulan Ini</h3>
          <p class="text-3xl font-bold text-emerald-800">
            {{ number_format($pelanggan->tagihan->last()->jumlah_meter ?? 0) }} kWh</p>
          <p class="mt-2 text-sm text-emerald-800">Periode {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}</p>
        </div>

        <div class="rounded-lg bg-purple-50 p-6 text-white">
          <h3 class="mb-1 text-base font-medium text-violet-700">Status Pembayaran</h3>
            <p class="text-2xl font-bold text-violet-800">
              {{ $pelanggan->tagihan->last()->status_pembayaran > 0 ? 'Belum ada tagihan' : 'Belum lunas' }}</p>
          @if ($jatuhTempo ?? false)
            <p class="mt-2 text-sm text-violet-800">Jatuh tempo: {{ $jatuhTempo }}</p>
          @endif
        </div>
      </div>

      <!-- Riwayat Tagihan -->
      <div class="overflow-x-auto">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">Riwayat Tagihan</h3>
        <div class="inline-block min-w-full align-middle">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Periode</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Meter Awal</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Meter Akhir</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Pemakaian</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Tagihan</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Status</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              @forelse($pelanggan->penggunaan ?? [] as $t)
                <tr class="transition-colors hover:bg-gray-50">
                  <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">
                    {{ \Carbon\Carbon::create($t->tahun, $t->bulan)->locale('id')->translatedFormat('F Y') }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                    {{ number_format($t->meter_awal) }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                    {{ number_format($t->meter_akhir) }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                    {{ number_format($t->meter_akhir - $t->meter_awal) }} kWh
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">
                    @php
                      $jumlah_meter = $t->meter_akhir - $t->meter_awal;
                      $total_tagihan = $jumlah_meter * $t->pelanggan->tarif->tarif_per_kWh;
                      if ($t->tagihan->pembayaran) {
                          $total_tagihan += $t->tagihan->pembayaran->biaya_admin;
                      }
                    @endphp
                    Rp {{ number_format($t->tagihan->pembayaran->total_bayar, 0, ',', '.') }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3">
                    @if ($t->tagihan->status_pembayaran === 1)
                      <span
                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        Lunas
                      </span>
                    @else
                      <span
                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        Belum Lunas
                      </span>
                    @endif
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-sm">
                    @if ($t->status === 'belum_dibayar')
                      <form action="{{ route('pembayaran.store') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="tagihan_id" value="{{ $t->id }}">
                        <button type="submit"
                          class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium leading-4 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                          </svg>
                          Proses Pembayaran
                        </button>
                      </form>
                    @else
                      <a href="{{ route('pembayaran.show', $t->tagihan->pembayaran->id ?? '#') }}"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail Pembayaran
                      </a>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
