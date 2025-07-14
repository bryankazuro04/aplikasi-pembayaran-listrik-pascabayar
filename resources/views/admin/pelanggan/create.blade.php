@extends('layouts.app')

@section('main')
  <div class="mx-auto max-w-4xl p-4 sm:p-6">
    <div class="overflow-hidden rounded-xl bg-white shadow-lg">
      <!-- Header Section -->
      <div class="border-b bg-gray-50 px-4 py-4 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-xl font-bold text-gray-800 sm:text-2xl">Tambah Pelanggan Baru</h2>
            <p class="mt-1 text-sm text-gray-600">Isi formulir di bawah untuk mendaftarkan pelanggan baru</p>
          </div>
          <a href="{{ route('pelanggan.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-colors duration-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
          </a>
        </div>
      </div>

      <!-- Form Section -->
      <form action="{{ route('pelanggan.store') }}" method="POST" class="p-4 sm:p-6">
        @csrf

        <!-- Error Messages -->
        @if ($errors->any())
          <div class="mb-6 rounded-lg bg-red-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan:</h3>
                <div class="mt-2 text-sm text-red-700">
                  <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:gap-8">
          <!-- Informasi Akun -->
          <div class="space-y-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Akun</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <!-- Username -->
              <div class="space-y-2">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <div class="relative rounded-md shadow-sm">
                  <input type="text" id="username" name="username"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="John Doe" required>
                </div>
              </div>

              <!-- Password -->
              <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                  class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                  placeholder="********" required>
              </div>

              <!-- Password Confirmed -->
              <div class="space-y-2 md:col-span-2">
                <label for="passwordConfirmed" class="block text-sm font-medium text-gray-700">Password Confirmed</label>
                <input id="passwordConfirmed" name="password_confirmation" type="password"
                  class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                  placeholder="********" required></input>
              </div>
            </div>
          </div>

          <!-- Informasi Pelanggan -->
          <div class="space-y-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <!-- Nomor Meter -->
              <div class="space-y-2">
                <label for="nomor_kwh" class="block text-sm font-medium text-gray-700">Nomor Meter</label>
                <div class="relative rounded-md shadow-sm">
                  <input type="text" id="nomor_kwh" name="nomor_kwh"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Contoh: 5372-8392-1234" required>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                  </div>
                </div>
                <small class="text-xs text-gray-500">Format: XXXX-XXXX-XXXX</small>
              </div>

              <!-- Nama Pelanggan -->
              <div class="space-y-2">
                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                  class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                  placeholder="Masukkan nama lengkap" required>
              </div>

              <!-- Alamat -->
              <div class="space-y-2 md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="3"
                  class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                  placeholder="Masukkan alamat lengkap" required></textarea>
              </div>
            </div>
          </div>

          <!-- Informasi Layanan -->
          <div class="space-y-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Layanan</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <!-- Tarif -->
              <div class="space-y-1 md:col-span-2">
                <label for="id_tarif" class="block text-sm font-medium text-gray-700">Pilih Tarif Listrik</label>
                <select id="id_tarif" name="id_tarif"
                  class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                  required>
                  <option value="">-- Pilih Tarif --</option>
                  @foreach ($tarif ?? [] as $t)
                    <option value="{{ $t->id }}">
                      {{ number_format($t->daya) }} VA - Rp{{ number_format($t->tarif_per_kWh, 0, ',', '.') }}/kWh
                    </option>
                  @endforeach
                </select>
                <small class="text-xs text-gray-500">Pilih sesuai dengan daya listrik yang terpasang</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end sm:space-x-4">
          <button type="reset"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-colors duration-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Reset
          </button>
          <button type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Simpan Data
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
