@extends('layouts.app')

@section('main')
    <h1 class="text-2xl font-bold mb-6">Daftar Penggunaan Listrik</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Nama Pelanggan</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Bulan & Tahun</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Meter Awal</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Meter Akhir</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($penggunaans as $index => $penggunaan)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ $penggunaan->pelanggan->nama_pelanggan }}</td>
                        <td class="py-3 px-4">{{ date('F Y', strtotime($penggunaan->tahun . '-' . $penggunaan->bulan)) }}</td>
                        <td class="py-3 px-4">{{ $penggunaan->meter_awal }}</td>
                        <td class="py-3 px-4">{{ $penggunaan->meter_akhir }}</td>
                        <td class="py-3 px-4">
                            @if(!\App\Models\Tagihan::where('id_penggunaan', $penggunaan->id)->exists())
                                <a href="{{ route('tagihan.create', ['penggunaan_id' => $penggunaan->id]) }}" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    Buat Tagihan
                                </a>
                            @else
                                <span class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                    Tagihan Dibuat
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data penggunaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection