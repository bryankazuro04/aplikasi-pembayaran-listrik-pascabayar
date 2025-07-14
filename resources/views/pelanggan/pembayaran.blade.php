@extends('layouts.app')

@section('main')
  <div class="mx-auto max-w-2xl px-4 py-8">
    <div class="mb-8 text-center">
      <h1 class="text-3xl font-bold text-gray-800">Konfirmasi Pembayaran</h1>
      <p class="mt-2 text-gray-600">Satu langkah lagi untuk menyelesaikan tagihan Anda. Mohon periksa kembali detail di
        bawah ini.</p>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-lg">
      <div class="p-6 md:p-8">

        <h2 class="mb-4 text-lg font-semibold text-gray-700">Detail Tagihan</h2>
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Nama Pelanggan</span>
            <span class="text-right font-semibold text-gray-800">{{ $tagihan->pelanggan->nama_pelanggan }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Nomor KWH</span>
            <span class="text-right font-semibold text-gray-800">{{ $tagihan->pelanggan->nomor_kwh }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Periode Tagihan</span>
            <span
              class="text-right font-semibold text-gray-800">{{ \Carbon\Carbon::create($tagihan->tahun, $tagihan->bulan)->locale('id')->translatedFormat('F Y') }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">Jumlah Penggunaan</span>
            <span class="text-right font-semibold text-gray-800">{{ $tagihan->jumlah_meter }} kWh</span>
          </div>
        </div>

        <hr class="my-6">

        <h2 class="mb-4 text-lg font-semibold text-gray-700">Rincian Biaya</h2>
        <div class="space-y-3">
          <div class="flex items-center justify-between text-gray-600">
            <span>Tagihan Pemakaian</span>
            {{-- Saran: Sebaiknya hasil perkalian ini dihitung di Controller dan dilempar sebagai variabel tunggal --}}
            <span class="font-medium">Rp
              {{ number_format($tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarif_per_kwh, 0, ',', '.') }}</span>
          </div>
          <div class="flex items-center justify-between text-gray-600">
            <span>Biaya Admin</span>
            <span class="font-medium">Rp {{ number_format($biaya_admin, 0, ',', '.') }}</span>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-between border-t-2 border-dashed pt-4">
          <span class="text-xl font-bold text-gray-800">Total Bayar</span>
          <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
        </div>

      </div>

      <div class="bg-gray-50 p-6">
        @if ($tagihan->status_pembayaran != 0)
          <div class="text-center">
            <p class="text-lg font-semibold text-green-600">Pembayaran Sudah Lunas</p>
          </div>
        @else
          <form action="{{ route('pembayaran.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $tagihan->id }}">
            <input type="hidden" name="biaya_admin" value="{{ $biaya_admin }}">
            <button type="submit"
              class="flex w-full items-center justify-center rounded-lg bg-green-500 px-6 py-3 text-lg font-bold text-white transition duration-300 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300">
              <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
              </svg>
              Konfirmasi dan Bayar
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
@endsection
