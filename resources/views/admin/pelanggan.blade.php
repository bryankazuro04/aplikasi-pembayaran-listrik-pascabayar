@extends('layouts.app')

@section('main')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="md:flex md:items-center md:justify-between">
          <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">
              Data Pelanggan
            </h2>
            <p class="mt-1 text-sm text-gray-500">
              Kelola data pelanggan listrik pascabayar
            </p>
          </div>
          <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('pelanggan.create') }}"
              class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Tambah Pelanggan
            </a>
          </div>
        </div>
      </div>

      <!-- Success/Error Messages -->
      @if (session('success'))
        <div class="mb-6 rounded-md border border-green-200 bg-green-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
          </div>
        </div>
      @endif

      @if (session('error'))
        <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
          </div>
        </div>
      @endif

      <!-- Table Card -->
      <div class="overflow-hidden rounded-lg bg-white shadow-xl">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            Daftar Pelanggan
          </h3>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  No</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Nomor Meteran</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Alamat</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Tarif</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              @forelse($pelanggan as $index => $p)
                <tr class="transition duration-150 hover:bg-gray-50">
                  <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                  <td class="whitespace-nowrap px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $p->nomor_kwh }}</div>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $p->nama_pelanggan }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="max-w-xs truncate text-sm text-gray-900">{{ $p->alamat }}</div>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">
                    <span
                      class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                      {{ $p->tarif->daya ?? '-' }} VA
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">
                    <span
                      class="{{ $p->status != 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                      {{ ucfirst($p->tagihan[0]->status_pembayaran ?? 'Belum Ada Tagihan') }}

                    </span>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                    <div class="flex space-x-2">
                      <button
                        onclick="editPelanggan(this)"
                        data-id="{{ $p->id }}"
                        data-id_tarif="{{ $p->id_tarif }}"
                        data-nomor_kwh="{{ $p->nomor_kwh }}"
                        data-nama_pelanggan="{{ $p->nama_pelanggan }}"
                        data-alamat="{{ $p->alamat }}"
                        class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white transition duration-200 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                          class="inline-flex items-center rounded-md border border-transparent bg-red-500 px-3 py-1.5 text-xs font-medium text-white transition duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                    <div class="flex flex-col items-center">
                      <svg class="mb-4 h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <p class="mb-1 text-lg font-medium text-gray-900">Belum ada data pelanggan</p>
                      <p class="text-gray-500">Mulai dengan menambahkan pelanggan baru</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50">
    <div class="relative top-20 mx-auto w-96 rounded-md border bg-white p-5 shadow-lg">
      <div class="mt-3">
        <div class="mb-4 flex items-center justify-between">
          <h3 class="text-lg font-medium text-gray-900">Edit Pelanggan</h3>
          <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <form id="editPelangganForm" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="edit_id_tarif" class="mb-2 block text-sm font-medium text-gray-700">Tarif</label>
            <select id="edit_id_tarif" name="id_tarif" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="" disabled>Pilih Tarif</option>
              @foreach ($tarifs ?? [] as $tarif)
                <option value="{{ $tarif->id }}">{{ $tarif->daya }} VA - Rp
                  {{ number_format($tarif->tarif_per_kwh, 0, ',', '.') }}/kWh</option>
              @endforeach
            </select>
          </div>


          <div class="mb-4">
            <label for="edit_nomor_kwh" class="mb-2 block text-sm font-medium text-gray-700">Nomor Meteran</label>
            <input type="number" id="edit_nomor_kwh" name="nomor_kwh" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div class="mb-4">
            <label for="edit_nama_pelanggan" class="mb-2 block text-sm font-medium text-gray-700">Nama Pelanggan</label>
            <input type="text" id="edit_nama_pelanggan" name="nama_pelanggan" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div class="mb-6">
            <label for="edit_alamat" class="mb-2 block text-sm font-medium text-gray-700">Alamat</label>
            <textarea id="edit_alamat" name="alamat" rows="3" required
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          </div>

          <div class="flex justify-end space-x-3">
            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
              class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
              Batal
            </button>
            <button type="submit"
              class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
              Simpan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      function editPelanggan(button) {
        const id = button.getAttribute('data-id');
        const id_tarif = button.getAttribute('data-id_tarif');
        const nomor_kwh = button.getAttribute('data-nomor_kwh');
        const nama_pelanggan = button.getAttribute('data-nama_pelanggan');
        const alamat = button.getAttribute('data-alamat');
        
        const form = document.getElementById('editPelangganForm');
        form.action = `/pelanggan/${id}`;
        document.getElementById('edit_id_tarif').value = id_tarif;
        document.getElementById('edit_nomor_kwh').value = nomor_kwh;
        document.getElementById('edit_nama_pelanggan').value = nama_pelanggan;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('editModal').classList.remove('hidden');
      }
    </script>
  @endpush
@endsection
