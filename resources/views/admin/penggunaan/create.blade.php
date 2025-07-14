@extends('layouts.app')

@section('main')
  <div class="bg-gray-50">
    <div class="container mx-auto max-w-2xl px-6 py-12">
      <div class="rounded-xl border border-gray-100 bg-white shadow-xl">
        <!-- Header -->
        <div class="border-b border-gray-100 px-8 py-6">
          <h1 class="text-xl font-semibold text-gray-900">Tambah Data Penggunaan</h1>
        </div>

        <!-- Form Content -->
        <div class="p-8">
          <form action="{{ route('penggunaan.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Pelanggan -->
            <div class="relative space-y-2">
              <label for="id_pelanggan" class="block text-sm font-medium text-gray-600">Pilih Pelanggan</label>

              <select id="id_pelanggan" name="id_pelanggan"
                class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach ($pelanggans as $pelanggan)
                  <option value="{{ $pelanggan->id }}" {{ old('id_pelanggan') == $pelanggan->id ? 'selected' : '' }}>
                    {{ $pelanggan->nomor_kwh }} - {{ $pelanggan->nama_pelanggan }}
                  </option>
                @endforeach
              </select>
              
              @error('id_pelanggan')
                <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Periode -->
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="bulan" class="block text-sm font-medium text-gray-600">Bulan</label>
                <select name="bulan" id="bulan"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  required>
                  <option value="" disabled selected>Pilih Bulan</option>
                  <option value="1" {{ old('bulan') == 1 ? 'selected' : '' }}>Januari</option>
                  <option value="2" {{ old('bulan') == 2 ? 'selected' : '' }}>Februari</option>
                  <option value="3" {{ old('bulan') == 3 ? 'selected' : '' }}>Maret</option>
                  <option value="4" {{ old('bulan') == 4 ? 'selected' : '' }}>April</option>
                  <option value="5" {{ old('bulan') == 5 ? 'selected' : '' }}>Mei</option>
                  <option value="6" {{ old('bulan') == 6 ? 'selected' : '' }}>Juni</option>
                  <option value="7" {{ old('bulan') == 7 ? 'selected' : '' }}>Juli</option>
                  <option value="8" {{ old('bulan') == 8 ? 'selected' : '' }}>Agustus</option>
                  <option value="9" {{ old('bulan') == 9 ? 'selected' : '' }}>September</option>
                  <option value="10" {{ old('bulan') == 10 ? 'selected' : '' }}>Oktober</option>
                  <option value="11" {{ old('bulan') == 11 ? 'selected' : '' }}>November</option>
                  <option value="12" {{ old('bulan') == 12 ? 'selected' : '' }}>Desember</option>
                </select>
                
                @error('bulan')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div class="space-y-2">
                <label for="tahun" class="block text-sm font-medium text-gray-600">Tahun</label>
                <input type="number" name="tahun" id="tahun"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('tahun', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}" required>
                
                @error('tahun')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Meter Reading -->
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="meter_awal" class="block text-sm font-medium text-gray-600">Meter Awal</label>
                <input type="number" name="meter_awal" id="meter_awal"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('meter_awal') }}" min="0" step="0.01" placeholder="kWh" required>
                
                @error('meter_awal')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div class="space-y-2">
                <label for="meter_akhir" class="block text-sm font-medium text-gray-600">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="meter_akhir"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('meter_akhir') }}" min="0" step="0.01" placeholder="kWh" required>
                
                @error('meter_akhir')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-8">
              <button type="submit"
                class="rounded-lg bg-sky-500 px-6 py-3 font-medium text-white transition-all hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                Simpan
              </button>
              <a href="{{ route('penggunaan.index') }}"
                class="rounded-lg px-6 py-3 font-medium text-gray-600 transition-all hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection