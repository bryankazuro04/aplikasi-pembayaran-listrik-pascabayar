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
            <div class="space-y-2 relative">
              <label for="nomor_kwh_search" class="block text-sm font-medium text-gray-600">Cari Nomor KWH</label>
              <input type="search" 
                     id="nomor_kwh_search" 
                     name="nomor_kwh_search"
                     class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                     placeholder="Ketik nomor KWH atau nama pelanggan..." 
                     autocomplete="off" 
                     required>

              <ul id="autocomplete-results" class="absolute z-10 mt-1 hidden w-full border bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto"></ul>

              <input type="hidden" name="id_pelanggan" id="id_pelanggan" required>

              @error('id_pelanggan')
                <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
              
              <!-- Display selected customer info -->
              <div id="selected-customer" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                <span class="text-sm text-blue-800">Pelanggan terpilih: </span>
                <span id="selected-info" class="text-sm font-medium text-blue-900"></span>
              </div>
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
              </div>

              @error('bulan')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

              <div class="space-y-2">
                <label for="tahun" class="block text-sm font-medium text-gray-600">Tahun</label>
                <input type="number" name="tahun" id="tahun"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('tahun', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}" required>
              </div>

               @error('tahun')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meter Reading -->
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="meter_awal" class="block text-sm font-medium text-gray-600">Meter Awal</label>
                <input type="number" name="meter_awal" id="meter_awal" step="0.01"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('meter_awal') }}" min="0" step="0.01" placeholder="kWh" required>

                  @error('meter_awal')
                  <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div class="space-y-2">
                <label for="meter_akhir" class="block text-sm font-medium text-gray-600">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="meter_akhir" step="0.01"
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

  @push('scripts')
    <script>
      const searchInput = document.getElementById("nomor_kwh_search");
      const resultBox = document.getElementById("autocomplete-results");
      const idInput = document.getElementById("id_pelanggan");
      const selectedCustomer = document.getElementById("selected-customer");
      const selectedInfo = document.getElementById("selected-info");
      
      let searchTimeout;

      searchInput.addEventListener("input", function() {
        const query = this.value.trim();

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Hide results if query is too short
        if (query.length < 2) {
          resultBox.innerHTML = "";
          resultBox.classList.add("hidden");
          clearSelectedCustomer();
          return;
        }

        // Add loading indicator
        resultBox.innerHTML = '<li class="px-4 py-2 text-gray-500">Mencari...</li>';
        resultBox.classList.remove("hidden");

        // Debounce search
        searchTimeout = setTimeout(() => {
          fetch(`/pelanggan/search?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then(data => {
            console.log('Search results:', data); // Debug log
            
            resultBox.innerHTML = "";
            
            if (data.length === 0) {
              resultBox.innerHTML = '<li class="px-4 py-2 text-gray-500">Tidak ada data ditemukan</li>';
              setTimeout(() => {
                resultBox.classList.add("hidden");
              }, 2000);
              return;
            }

            data.forEach(item => {
              const li = document.createElement("li");
              li.textContent = `${item.nomor_kwh} - ${item.nama_pelanggan}`;
              li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0";
              li.addEventListener("click", () => {
                selectCustomer(item);
              });
              resultBox.appendChild(li);
            });

            resultBox.classList.remove("hidden");
          })
          .catch(error => {
            console.error('Fetch error:', error);
            resultBox.innerHTML = '<li class="px-4 py-2 text-red-500">Error dalam pencarian</li>';
            setTimeout(() => {
              resultBox.classList.add("hidden");
            }, 2000);
          });
        }, 300); // 300ms delay
      });

      function selectCustomer(item) {
        searchInput.value = `${item.nomor_kwh} - ${item.nama_pelanggan}`;
        idInput.value = item.id;
        resultBox.classList.add("hidden");
        
        // Show selected customer info
        selectedInfo.textContent = `${item.nomor_kwh} - ${item.nama_pelanggan}`;
        selectedCustomer.classList.remove("hidden");
      }

      function clearSelectedCustomer() {
        idInput.value = "";
        selectedCustomer.classList.add("hidden");
      }

      // Close autocomplete on outside click
      document.addEventListener("click", function(e) {
        if (!searchInput.contains(e.target) && !resultBox.contains(e.target)) {
          resultBox.classList.add("hidden");
        }
      });

      // Clear selection when input is manually changed
      searchInput.addEventListener("keydown", function(e) {
        if (e.key === "Backspace" || e.key === "Delete") {
          clearSelectedCustomer();
        }
      });
    </script>
  @endpush
@endsection