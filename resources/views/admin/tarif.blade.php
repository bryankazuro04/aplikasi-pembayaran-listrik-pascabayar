@extends('layouts.app')

@section('main')
  <div class="p-4 sm:p-6">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Manajemen Tarif Listrik</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola daya dan tarif listrik per kWh</p>
      </div>
      <button onclick="document.getElementById('addTarifModal').classList.remove('hidden')"
        class="flex items-center justify-center space-x-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors w-full sm:w-auto">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        <span>Tambah Tarif Baru</span>
      </button>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden rounded-lg bg-white shadow-lg">
      <div class="overflow-x-auto">
        <!-- Mobile View (Card Layout) -->
        <div class="block sm:hidden">
          @forelse($tarifs ?? [] as $tarif)
            <div class="p-4 border-b border-gray-200 hover:bg-gray-50">
              <div class="flex justify-between items-center mb-2">
                <span class="font-medium text-gray-900">{{ number_format($tarif->daya) }} VA</span>
                <div class="flex space-x-2">
                  <button onclick="editTarif({{ $tarif->id }})" class="text-blue-600 hover:text-blue-900">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  @if(($tarif->pelanggan_count ?? 0) == 0)
                    <button onclick="deleteTarif({{ $tarif->id }})" class="text-red-600 hover:text-red-900">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </button>
                  @endif
                </div>
              </div>
              <div class="space-y-1 text-sm">
                <p class="text-gray-600">Tarif: Rp {{ number_format($tarif->tarifperkwh, 0, ',', '.') }}/kWh</p>
                <p class="text-gray-600">Biaya Admin: Rp {{ number_format($tarif->biaya_admin, 0, ',', '.') }}</p>
                <p class="text-gray-600">{{ $tarif->pelanggan_count ?? 0 }} Pelanggan</p>
              </div>
            </div>
          @empty
            <div class="p-4 text-center text-gray-500">
              Belum ada data tarif
            </div>
          @endforelse
        </div>

        <!-- Desktop View (Table Layout) -->
        <table class="hidden sm:table min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Daya (VA)</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tarif per kWh</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Beban Biaya Admin</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah Pelanggan</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($tarifs ?? [] as $tarif)
              <tr class="hover:bg-gray-50">
                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                  {{ number_format($tarif->daya) }} VA
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  Rp {{ number_format($tarif->tarifperkwh, 0, ',', '.') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  Rp {{ number_format($tarif->biaya_admin, 0, ',', '.') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  {{ $tarif->pelanggan_count ?? 0 }} Pelanggan
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  <div class="flex space-x-3">
                    <button onclick="editTarif({{ $tarif->id }})" class="text-blue-600 hover:text-blue-900">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    @if(($tarif->pelanggan_count ?? 0) == 0)
                      <button onclick="deleteTarif({{ $tarif->id }})" class="text-red-600 hover:text-red-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                      </button>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                  Belum ada data tarif
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Tambah Tarif -->
    <div id="addTarifModal" class="fixed inset-0 hidden h-full w-full overflow-y-auto bg-gray-600/40 p-4">
      <div class="flex min-h-screen items-center justify-center">
        <div class="relative w-full max-w-md rounded-lg border border-gray-200 bg-white p-6 shadow-xl">
          <div class="mb-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Tambah Tarif Baru</h3>
            <button onclick="document.getElementById('addTarifModal').classList.add('hidden')"
              class="absolute right-4 top-4 text-gray-400 hover:text-gray-500">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form action="{{ route('tarif.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Daya (VA)</label>
                <input type="number" name="daya" required placeholder="Contoh: 900"
                  class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm 
                         focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700">Tarif per kWh (Rp)</label>
                <input type="number" name="tarifperkwh" required placeholder="Contoh: 1500"
                  class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm 
                         focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700">Biaya Admin (Rp)</label>
                <input type="number" name="biaya_admin" required placeholder="Contoh: 3000"
                  class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm 
                         focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
              </div>
            </div>
            
            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 gap-2">
              <button type="button" onclick="document.getElementById('addTarifModal').classList.add('hidden')"
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium 
                       text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 
                       focus:ring-offset-2">
                Batal
              </button>
              <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm 
                       font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 
                       focus:ring-blue-500 focus:ring-offset-2">
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      function editTarif(id) {
        window.location.href = `/tarif/${id}/edit`;
      }

      function deleteTarif(id) {
        if (confirm('Apakah Anda yakin ingin menghapus tarif ini?')) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = `/tarif/${id}`;

          const methodInput = document.createElement('input');
          methodInput.type = 'hidden';
          methodInput.name = '_method';
          methodInput.value = 'DELETE';

          const tokenInput = document.createElement('input');
          tokenInput.type = 'hidden';
          tokenInput.name = '_token';
          tokenInput.value = '{{ csrf_token() }}';

          form.appendChild(methodInput);
          form.appendChild(tokenInput);
          document.body.appendChild(form);
          form.submit();
        }
      }
    </script>
  @endpush
@endsection
