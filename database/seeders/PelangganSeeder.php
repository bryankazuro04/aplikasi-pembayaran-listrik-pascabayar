<?php

namespace Database\Seeders;

use App\Models\pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pelanggan::create([
            'id_tarif' => 1, // Pastikan ID tarif ini sesuai dengan yang ada di database
            'username' => 'pelanggan1',
            'password' => bcrypt('password123'), // Ganti dengan password yang sesuai
            'nomor_KWh' => '1234567890', // Ganti dengan nomor KWh yang sesuai
            'nama_pelanggan' => 'Pelanggan Satu',
        ]);
    }
}
