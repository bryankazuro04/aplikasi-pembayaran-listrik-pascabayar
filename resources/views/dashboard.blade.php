@extends('layouts.app')

@section('main')
  <div class="p-6">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Dashboard Admin</h1>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
      <div class="rounded-lg bg-blue-500 p-4 text-white shadow-lg">
        <h3 class="mb-2 text-lg font-semibold">Total Pelanggan</h3>
        <p class="text-3xl font-bold">{{ number_format($totalPelanggan ?? 0) }}</p>
      </div>

      <div class="rounded-lg bg-green-500 p-4 text-white shadow-lg">
        <h3 class="mb-2 text-lg font-semibold">Pembayaran Bulan Ini</h3>
        <p class="text-3xl font-bold">Rp {{ number_format($pembayaranBulanIni ?? 0, 0, ',', '.') }}</p>
      </div>

      <div class="rounded-lg bg-yellow-500 p-4 text-white shadow-lg">
        <h3 class="mb-2 text-lg font-semibold">Tagihan Belum Lunas</h3>
        <p class="text-3xl font-bold">{{ number_format($tagihanBelumLunas ?? 0) }}</p>
      </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
      <a href="{{ route('pelanggan.create') }}" class="rounded-lg bg-white p-4 shadow transition-shadow hover:shadow-md">
        <div class="flex items-center space-x-3">
          <div class="rounded-full bg-blue-100 p-3">
            <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
          </div>

          <div>
            <h3 class="font-semibold text-gray-800">Tambah Pelanggan</h3>
            <p class="text-sm text-gray-600">Daftarkan pelanggan baru</p>
          </div>
        </div>
      </a>

      <a href="{{ route('penggunaan.index') }}" class="rounded-lg bg-white p-4 shadow transition-shadow hover:shadow-md">
        <div class="flex items-center space-x-3">
          <div class="rounded-full bg-green-100 p-3">
            <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
          </div>

          <div>
            <h3 class="font-semibold text-gray-800">Input Penggunaan</h3>
            <p class="text-sm text-gray-600">Catat meter listrik</p>
          </div>
        </div>
      </a>
    </div>

    <div class="rounded-lg bg-white p-6 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Tagihan Terbaru</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nomor Meter</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Periode</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Penggunaan</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total Tagihan
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($tagihanTerbaru ?? [] as $tagihan)
              <tr>
                <td class="whitespace-nowrap px-6 py-4">{{ $tagihan->pelanggan->nomor_kwh }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $tagihan->pelanggan->nama_pelanggan }}</td>
                <td class="whitespace-nowrap px-6 py-4">
                  {{ \Carbon\Carbon::create($tagihan->tahun, $tagihan->bulan)->locale('id')->translatedFormat('F Y') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  {{ number_format($tagihan->penggunaan->meter_akhir - $tagihan->penggunaan->meter_awal) }} kWh</td>
                <td class="whitespace-nowrap px-6 py-4">
                  @php
                    $jumlahMeter = $tagihan->penggunaan->meter_akhir - $tagihan->penggunaan->meter_awal;
                    $tarifPerKwh = $tagihan->pelanggan->tarif->tarif_per_kwh ?? 0;
                    $biayaAdmin = 2500;
                    $totalTagihan = $jumlahMeter * $tarifPerKwh + $biayaAdmin;
                  @endphp
                  Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                  @if ($tagihan->status_pembayaran)
                    <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">Lunas</span>
                  @else
                    <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">Belum Lunas</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                  Tidak ada tagihan terbaru
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
      <div class="rounded-lg bg-white p-6 shadow-lg">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Pembayaran per Bulan</h2>
        <div class="h-64">
          <canvas id="pembayaranChart"></canvas>
        </div>
      </div>

      <div class="rounded-lg bg-white p-6 shadow-lg">
        <h2 class="mb-4 text-xl font-semibold text-gray-800">Status Tagihan</h2>
        <div class="h-64">
          <canvas id="tagihanChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const pembayaranCtx = document.getElementById('pembayaranChart').getContext('2d');
      new Chart(pembayaranCtx, {
        type: 'bar',
        data: {
          labels: {!! json_encode($bulan ?? []) !!},
          datasets: [{
            label: 'Total Pembayaran',
            data: {!! json_encode($totalPembayaranPerBulan ?? []) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: 'rgb(59, 130, 246)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });

      const tagihanCtx = document.getElementById('tagihanChart').getContext('2d');
      new Chart(tagihanCtx, {
        type: 'doughnut',
        data: {
          labels: ['Lunas', 'Belum Lunas'],
          datasets: [{
            data: [{{ $tagihanLunas ?? 0 }}, {{ $tagihanBelumLunas ?? 0 }}],
            backgroundColor: [
              'rgba(34, 197, 94, 0.5)',
              'rgba(239, 68, 68, 0.5)'
            ],
            borderColor: [
              'rgb(34, 197, 94)',
              'rgb(239, 68, 68)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        }
      });
    </script>
  @endpush
@endsection
