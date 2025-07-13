<?php

namespace Database\Seeders;

use App\Models\pembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pembayaran::create([
            'id_tagihan' => 1, // Pastikan ID tagihan ini sesuai dengan yang ada di database
            'id_pelanggan' => 1, // Pastikan ID pelanggan ini sesuai dengan yang ada di database
            'tanggal_pembayaran' => now(),
            'bulan' => 7,
            'biaya_admin' => 2500, // Contoh biaya admin, sesuaikan dengan kebutuhan
            'total_bayar' => 50000,
            'id_user' => 1, // Pastikan ID user ini sesuai dengan yang ada di database
        ]);
    }
}
