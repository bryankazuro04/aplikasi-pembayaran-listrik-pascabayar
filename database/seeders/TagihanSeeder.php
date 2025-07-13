<?php

namespace Database\Seeders;

use App\Models\tagihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tagihan::create([
            'id_penggunaan' => 1, // Pastikan ID penggunaan ini sesuai dengan yang ada di database
            'id_pelanggan' => 1, // Pastikan ID pelanggan ini sesuai dengan yang ada di database
            'bulan' => 1,
            'tahun' => 2023,
            'jumlah_meter' => 100,
            'status_pembayaran' => false,
        ]);
    }
}
