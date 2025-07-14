@extends('layouts.app')

@section('main')
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="mb-2 text-3xl font-bold text-gray-800">Daftar Penggunaan Listrik</h1>
      <p class="text-gray-600">Kelola data penggunaan listrik pelanggan untuk pencatatan tagihan</p>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex items-center justify-between">
      <div class="flex space-x-3">
        <a href="{{ route('penggunaan.create') }}"
          class="rounded-md bg-green-600 px-4 py-2 text-white transition duration-150 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
          <i class="fas fa-plus mr-2"></i>Tambah Penggunaan
        </a>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-xl">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'id_pelanggan', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                  class="flex items-center hover:text-gray-700">
                  ID Pelanggan
                  <i class="fas fa-sort ml-1"></i>
                </a>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Nama Pelanggan
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'bulan', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                  class="flex items-center hover:text-gray-700">
                  Periode
                  <i class="fas fa-sort ml-1"></i>
                </a>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Meter Awal
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Meter Akhir
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Penggunaan
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($penggunaans as $penggunaan)
              <tr class="hover:bg-gray-50">
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="flex items-center">
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ $penggunaan->pelanggan->nomor_kwh }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="text-sm text-gray-900">{{ $penggunaan->pelanggan->nama_pelanggan ?? 'N/A' }}</div>
                  <div class="text-sm text-gray-500">{{ $penggunaan->pelanggan->alamat ?? '' }}</div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="text-sm text-gray-900">
                    {{ \Carbon\Carbon::createFromFormat('n', $penggunaan->bulan)->format('F') }}
                    {{ $penggunaan->tahun }}
                  </div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="text-sm text-gray-900">{{ number_format($penggunaan->meter_awal) }}</div>
                  <div class="text-sm text-gray-500">kWh</div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="text-sm text-gray-900">{{ number_format($penggunaan->meter_akhir) }}</div>
                  <div class="text-sm text-gray-500">kWh</div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">
                    {{ number_format($penggunaan->meter_akhir - $penggunaan->meter_awal) }}
                  </div>
                  <div class="text-sm text-gray-500">kWh</div>
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  @if ($penggunaan->tagihan_dibuat ?? false)
                    <span
                      class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                      <i class="fas fa-check-circle mr-1"></i>
                      Tagihan Dibuat
                    </span>
                  @else
                    <span
                      class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                      <i class="fas fa-clock mr-1"></i>
                      Belum Ditagihkan
                    </span>
                  @endif
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                  <div class="flex items-center space-x-2">
                    <a href="{{ route('penggunaan.show', $penggunaan->id) }}" class="text-blue-600 hover:text-blue-900">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                      </svg>
                    </a>
                    <a href="{{ route('penggunaan.edit', $penggunaan->id) }}"
                      class="text-indigo-600 hover:text-indigo-900">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                      </svg>
                    </a>
                    @if (!($penggunaan->tagihan_dibuat ?? false))
                      <a href="{{ route('tagihan.create', ['penggunaan_id' => $penggunaan->id]) }}"
                        class="text-green-600 hover:text-green-900" title="Buat Tagihan">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                          </path>
                        </svg>
                      </a>
                    @endif
                    <form method="POST" action="{{ route('penggunaan.destroy', $penggunaan->id) }}" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                          </path>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <i class="fas fa-inbox mb-4 text-4xl text-gray-300"></i>
                    <p class="text-lg">Tidak ada data penggunaan listrik</p>
                    <p class="text-sm">Mulai dengan menambahkan data penggunaan baru</p>
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
