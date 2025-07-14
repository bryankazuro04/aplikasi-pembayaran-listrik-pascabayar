@extends('layouts.app')

@section('main')
  <div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Penggunaan</h1>
        <p class="mt-1 text-gray-500">Kelola data meteran dan buat tagihan untuk pelanggan.</p>
      </div>
      <a href="{{ route('penggunaan.create') }}"
        class="inline-flex items-center rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:bg-blue-600 hover:shadow-lg">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Penggunaan
      </a>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-lg">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="border-b border-gray-200 bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">No</th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama Pelanggan
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Periode</th>
              <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Meter Awal
                (kWh)</th>
              <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Meter Akhir
                (kWh)</th>
              <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 text-gray-700">
            @forelse ($penggunaans as $penggunaan)
              <tr class="transition-colors duration-200 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $penggunaan->pelanggan->nama_pelanggan }}</td>
                <td class="px-6 py-4">{{ date('F Y', strtotime($penggunaan->tahun . '-' . $penggunaan->bulan)) }}</td>
                <td class="px-6 py-4 text-right">{{ number_format($penggunaan->meter_awal) }}</td>
                <td class="px-6 py-4 text-right">{{ number_format($penggunaan->meter_akhir) }}</td>
                <td class="px-6 py-4 text-center">
                  @if (!\App\Models\Tagihan::where('id_penggunaan', $penggunaan->id)->exists())
                    <a href="{{ route('tagihan.create', ['penggunaan_id' => $penggunaan->id]) }}"
                      class="inline-flex items-center rounded-lg bg-green-500 px-4 py-2 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:bg-green-600 hover:shadow-lg">
                      <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                      </svg>
                      Buat Tagihan
                    </a>
                  @else
                    <span class="inline-flex items-center text-sm font-semibold text-gray-500">
                      <svg class="mr-2 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"></path>
                      </svg>
                      Telah Ditagih
                    </span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                      </path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Data Penggunaan Kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Silakan tambahkan data penggunaan listrik terlebih dahulu.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
