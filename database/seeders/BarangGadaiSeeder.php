<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangGadaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

            $override = [
                'kategori' => $k['kategori'],
                'status' => $k['status'],
                'nama_barang' => $namaBarang,
            ];
            
            if ($k['status'] === 'lelang') {
                $override['jangka_waktu'] = 30;
                $override['tanggal_gadai'] = fake()->dateTimeBetween('-120 days', '-40 days');
            }

            \App\Models\BarangGadai::factory()->create($override);
        }

        \App\Models\BarangGadai::factory(19)->create();
    }
}
