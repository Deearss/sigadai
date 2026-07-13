<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Petugas Demo',
            'email' => 'demo@sigadai.my.id',
            'password' => bcrypt('sigadai123'),
        ]);

        $kombinasi = [
            ['kategori' => 'elektronik', 'status' => 'aktif'],
            ['kategori' => 'kendaraan', 'status' => 'aktif'],
            ['kategori' => 'elektronik', 'status' => 'ditebus'],
            ['kategori' => 'kendaraan', 'status' => 'ditebus'],
            ['kategori' => 'elektronik', 'status' => 'lelang'],
            ['kategori' => 'kendaraan', 'status' => 'lelang'],
        ];

        foreach ($kombinasi as $k) {
            $namaBarang = $k['kategori'] === 'elektronik' 
                ? fake()->randomElement(['iPhone 13 128GB', 'Laptop ASUS VivoBook 14', 'TV LED Samsung 43 inch', 'PS5'])
                : fake()->randomElement(['Honda Beat 2021', 'Yamaha NMAX 2022', 'Honda Vario 125 2020']);

            \App\Models\BarangGadai::factory()->create([
                'kategori' => $k['kategori'],
                'status' => $k['status'],
                'nama_barang' => $namaBarang,
            ]);
        }

        \App\Models\BarangGadai::factory(19)->create();
    }
}
