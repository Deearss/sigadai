<?php

namespace Database\Factories;

use App\Models\BarangGadai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BarangGadai>
 */
class BarangGadaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = fake()->randomElement(['elektronik', 'kendaraan']);
        
        if ($kategori === 'elektronik') {
            $namaBarang = fake()->randomElement([
                'iPhone 13 128GB', 'Laptop ASUS VivoBook 14', 'TV LED Samsung 43 inch',
                'PS5', 'Kamera Canon EOS M50', 'MacBook Air M1', 'iPad Pro 11 inch'
            ]);
            $taksiranNilai = fake()->numberBetween(5, 150) * 100000; // 500rb - 15jt
        } else {
            $namaBarang = fake()->randomElement([
                'Honda Beat 2021', 'Yamaha NMAX 2022', 'Honda Vario 125 2020',
                'Suzuki Nex II 2023', 'Honda Scoopy 2019', 'Yamaha Aerox 2021'
            ]);
            $taksiranNilai = fake()->numberBetween(50, 250) * 100000; // 5jt - 25jt
        }

        $status = fake()->randomElement(array_merge(
            array_fill(0, 60, 'aktif'),
            array_fill(0, 25, 'ditebus'),
            array_fill(0, 15, 'lelang')
        ));
        
        $jangkaWaktu = fake()->randomElement([30, 60, 90, 120]);

        if ($status === 'aktif') {
            $isOverdue = fake()->boolean(30); // 30% overdue
            if ($isOverdue) {
                $tanggalGadai = fake()->dateTimeBetween('-' . ($jangkaWaktu + 60) . ' days', '-' . ($jangkaWaktu + 1) . ' days');
            } else {
                $tanggalGadai = fake()->dateTimeBetween('-' . ($jangkaWaktu - 1) . ' days', 'now');
            }
        } else {
            $tanggalGadai = fake()->dateTimeBetween('-6 months', '-' . ($jangkaWaktu + 1) . ' days');
        }

        return [
            'nama_barang' => $namaBarang,
            'kategori' => $kategori,
            'taksiran_nilai' => $taksiranNilai,
            'jangka_waktu' => $jangkaWaktu,
            'nama_nasabah' => fake('id_ID')->name(),
            'no_hp' => '08' . fake()->numerify('##########'),
            'tanggal_gadai' => $tanggalGadai,
            'status' => $status,
            'catatan' => fake()->boolean(30) ? fake()->randomElement(['Mulus', 'Lecet pemakaian', 'Surat lengkap', 'Pajak hidup', 'Dus ada']) : null,
        ];
    }
}
