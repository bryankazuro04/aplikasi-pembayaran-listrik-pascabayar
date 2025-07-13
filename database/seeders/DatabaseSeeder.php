<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(LevelSeeder::class);
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'nama_admin' => 'Administrator',
            'id_level' => 1,
        ]);
        $this->call(TarifSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(PenggunaanSeeder::class);
        $this->call(TagihanSeeder::class);
        $this->call(PembayaranSeeder::class);

    }
}
