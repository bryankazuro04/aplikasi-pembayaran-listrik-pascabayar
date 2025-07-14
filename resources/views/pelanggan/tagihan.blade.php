@extends('layouts.app')

@section('main')
  <div class="container mx-auto px-4 py-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Daftar Tagihan Anda</h1>
      <p class="mt-1 text-gray-500">Berikut adalah riwayat tagihan listrik Anda.</p>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-lg">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="border-b border-gray-200 bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">No</th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Periode</th>
              <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Jumlah
                Penggunaan</th>
              <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
              <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 text-gray-700">
            @forelse ($tagihan as $index => $item)
              <tr class="transition-colors duration-200 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-medium">{{ date('F Y', strtotime($item->tahun . '-' . $item->bulan)) }}</td>
                <td class="px-6 py-4">{{ $item->jumlah_meter }} kWh</td>
                <td class="px-6 py-4 text-center">
                  @if ($item->status_pembayaran == 0)
                    <span
                      class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                      <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                      </svg>
                      Belum Lunas
                    </span>
                  @else
                    <span
                      class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                      <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                      </svg>
                      Lunas
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4 text-center">
                  @if ($item->status_pembayaran == 0)
                    <a href="{{ route('pembayaran.show', $item->id) }}"
                      class="inline-flex items-center rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:bg-blue-600 hover:shadow-lg">
                      <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                      </svg>
                      Bayar
                    </a>
                  @else
                    <a href="{{ route('tagihan.show', $item->id) }}"
                      class="inline-flex items-center rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition-all duration-200 hover:bg-gray-300">
                      <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                      Detail
                    </a>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">
                  <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak Ada Tagihan</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum memiliki riwayat tagihan apa pun.</p>
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
