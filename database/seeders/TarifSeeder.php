<?php

namespace Database\Seeders;

use App\Models\tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tarif::create([
            'daya' => 450,
            'tarif_per_kWh' => 1352,
        ]);
    }
}
