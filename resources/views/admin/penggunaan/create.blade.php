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
              {{-- <input type="search" 
                     id="nomor_kwh_search" 
                     name="nomor_kwh_search"
                     class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                     placeholder="Ketik nomor KWH atau nama pelanggan..." 
                     autocomplete="off" 
                     required> --}}

              {{-- <ul id="autocomplete-results" class="absolute z-10 mt-1 hidden w-full border bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto"></ul> --}}

              {{-- <input type="hidden" name="id_pelanggan" id="id_pelanggan" required> --}}

              <input type="text" id="nomor_kwh" placeholder="Ketik nomor KWH atau nama pelanggan..."
                     class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                     required autocomplete="off">
              <div class="dropdown-list" id="dropdown-list"></div>
              
              <button type="button" class="" onclick="searchPelanggan()">Cari</button>
              <button type="button" class="" onclick="clearData()">Clear</button>
              
            </div>

            <!-- Periode -->
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="bulan" class="block text-sm font-medium text-gray-600">Bulan</label>
                <select name="bulan" id="bulan"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  required>
                  <option value="" disabled selected>Pilih Bulan</option>
                  <option value="01">Januari</option>
                  <option value="02">Februari</option>
                  <option value="03">Maret</option>
                  <option value="04">April</option>
                  <option value="05">Mei</option>
                  <option value="06">Juni</option>
                  <option value="07">Juli</option>
                  <option value="08">Agustus</option>
                  <option value="09">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">November</option>
                  <option value="12">Desember</option>
                </select>
              </div>

              <div class="space-y-2">
                <label for="tahun" class="block text-sm font-medium text-gray-600">Tahun</label>
                <input type="number" name="tahun" id="tahun"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('tahun', date('Y')) }}" min="2020" max="{{ date('Y') + 1 }}" required>
              </div>
            </div>

            <!-- Meter Reading -->
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="meter_awal" class="block text-sm font-medium text-gray-600">Meter Awal</label>
                <input type="number" name="meter_awal" id="meter_awal"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('meter_awal') }}" min="0" step="0.01" placeholder="kWh" required>
              </div>

              <div class="space-y-2">
                <label for="meter_akhir" class="block text-sm font-medium text-gray-600">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="meter_akhir"
                  class="w-full rounded-lg border-0 bg-gray-50 px-4 py-3 transition-all focus:bg-white focus:outline-none focus:ring-1 focus:ring-gray-300"
                  value="{{ old('meter_akhir') }}" min="0" step="0.01" placeholder="kWh" required>
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
    {{-- <script>
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
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
          })
          .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            // Check if response is actually JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
              throw new Error('Response is not JSON');
            }
            
            return response.text(); // Get as text first
          })
          .then(text => {
            console.log('Raw response:', text);
            
            // Try to parse as JSON
            let data;
            try {
              data = JSON.parse(text);
            } catch (e) {
              throw new Error('Invalid JSON response: ' + text);
            }
            
            console.log('Parsed data:', data);
            
            resultBox.innerHTML = "";
            
            // Handle new response format
            const results = data.data || data; // Support both formats
            
            if (!Array.isArray(results) || results.length === 0) {
              resultBox.innerHTML = '<li class="px-4 py-2 text-gray-500">Tidak ada data ditemukan</li>';
              setTimeout(() => {
                resultBox.classList.add("hidden");
              }, 2000);
              return;
            }

            results.forEach(item => {
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
            resultBox.innerHTML = `<li class="px-4 py-2 text-red-500">Error: ${error.message}</li>`;
            setTimeout(() => {
              resultBox.classList.add("hidden");
            }, 3000);
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
    </script> --}}

    <script>
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

      const nomorKwhInput = document.getElementById('nomor_kwh');
      const dropdownList = document.getElementById('dropdown-list');
      // const pelangganInfo = document.getElementById('pelanggan-info')

      let selectedIndex = -1
      let searchTimeout
      let currentData = []

      nomorKwhInput.addEventListener('input', (e) => {
        const value = e.target.value.trim()

        if(value.length >= 2) {
          clearTimeout(searchTimeout)

          searchTimeout = setTimeout(() => {
            searchDropdown(value)
          }, 300)
        } else {
          hideDropdown()
        }
      })

      nomorKwhInput.addEventListener('focus', (e) => {
        const value = e.target.value.trim()

        if(value.length >= 2) {
          searchDropdown(value)
        }
      })

      nomorKwhInput.addEventListener('blur', (e) => {
        setTimeout(() => {
          hideDropdown()
        }, 200) // Delay to allow click on dropdown item
      })

      nomorKwhInput.addEventListener('keydown', (e) => {
        const items = dropdownList.querySelectorAll('.dropdown-item')

        if(e.key === 'ArrowDown') {
          e.preventDefault()
          selectedIndex = Math.min(selectedIndex + 1, items.length - 1)
          updateSelection(items)
        } else if (e.key === 'ArrowUp') {
          e.preventDefault()
          selectedIndex = Math.max(selectedIndex - 1, -1)
          updateSelection(items)
        } else if (e.key === 'Enter') {
          e.preventDefault()
          if(selectedIndex >= 0 && currentData[selectedIndex]) {
            selectItem(currentData[selectedIndex])
          } else {
            searchPelanggan()
          }
        } else if (e.key === 'Escape') {
          hideDropdown()
        }
      })

      function searchDropdown(query) {
        showLoading()

        fetch(`/pelanggan/search?query=${encodeURIComponent(query)}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          currentData = data
          showDropdown(data)
        })
        .catch(error => {
          console.error('Error fetching pelanggan:', error)
          hideDropdown()
        })
      }

      function showLoading() {
        dropdownList.innerHTML = '<div class="px-4 py-2 text-gray-500">Mencari...</div>';
        dropdownList.classList.add('block');
      }

      function showDropdown(items) {
        dropdownList.innerHTML = ''
        selectedIndex = -1

        if(items.length === 0) {
          dropdownList.innerHTML = '<div class="px-4 py-2 text-gray-500">Tidak ada data ditemukan</div>';
          dropdownList.classList.add('block');
          return;
        }

        items.forEach((item, index) => {
          const div = document.createElement('div')
          div.className = 'dropdown-item px-4 py-2 hover:bg-gray-100 cursor-pointer'
          div.innerHTML = `<strong>${item.nomor_kwh}</strong> - ${item.nama_pelanggan}`
          div.addEventListener('click', () => selectItem(item))
          dropdownList.appendChild(div)
        })

        dropdownList.classList.add('block')
      }

      function hideDropdown() {
        dropdownList.classList.remove('block')
        dropdownList.classList.add('hidden')
        selectedIndex = -1
      }

      function updateSelection(items) {
        items.forEach((item, index) => {
          item.classList.toggle('highlighted', index === selectedIndex)
        })
      }

      function selectItem(item) {
        nomorKwhInput.value = item.nomor_kwh
        hideDropdown()
      }

      function searchPelanggan() {
        const nomorKwh = nomorKwhInput.value.trim()

        if(!nomorKwh) {
          showAlert('Mohon masukkan nomor KWH atau nama pelanggan')
          return
        }

        fetch(`/pelanggan/get-by-nomor-kwh?nomor_kwh=${encodeURIComponent(nomorKwh)}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          if(data.success) {
            alert(`Pelanggan ditemukan: ${data.pelanggan.nama_pelanggan}`, 'success')
          } else {
            alert(data.message || 'Pelanggan tidak ditemukan', 'error')
          }
        })
        .catch(error => {
          console.error('Error fetching pelanggan:', error)
          alert('Terjadi kesalahan saat mencari pelanggan', 'error')
        })
      }

      function clearData() {
        nomorKwhInput.value = ''
        hideDropdown()
      }
    </script>
  @endpush
@endsection
