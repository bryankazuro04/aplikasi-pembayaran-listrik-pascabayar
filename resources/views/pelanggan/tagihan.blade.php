@extends('layouts.app')

@section('main')
    <h1 class="text-2xl font-bold mb-6">Daftar Tagihan Anda</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Periode</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Jumlah Meter</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($tagihan as $index => $item)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ date('F Y', strtotime($item->tahun . '-' . $item->bulan)) }}</td>
                        <td class="py-3 px-4">{{ $item->jumlah_meter }} kWh</td>
                        <td class="py-3 px-4">
                            @if($item->status_pembayaran == 0) <span class="bg-red-500 text-white px-3 py-1 rounded text-xs">Belum Dibayar</span>
                            @else
                                <span class="bg-green-500 text-white px-3 py-1 rounded text-xs">Lunas</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($item->status_pembayaran == 0) <a href="{{ route('pembayaran.show', $item->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    Bayar Sekarang
                                </a>
                            @else
                                <a href="{{ route('tagihan.show', $item->id) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">
                                    Lihat Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Anda belum memiliki tagihan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection