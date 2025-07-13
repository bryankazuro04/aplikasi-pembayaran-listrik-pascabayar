<?php

namespace Database\Seeders;

use App\Models\level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        level::create([
            'nama_level' => 'Admin',
        ]);
    }
}
