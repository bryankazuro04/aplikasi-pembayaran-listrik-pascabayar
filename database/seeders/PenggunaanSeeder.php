<?php

namespace Database\Seeders;

use App\Models\penggunaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenggunaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        penggunaan::create([
            'id_pelanggan' => 1, // Pastikan ID pelanggan ini sesuai dengan yang ada di database
            'bulan' => 1,
            'tahun' => 2023,
            'meter_awal' => 100,
            'meter_akhir' => 200,
        ]);
    }
}
