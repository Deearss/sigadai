# TASK-02: Factory + Seeder dummy + akun demo

**Status:** ✅ Selesai
**Prasyarat:** TASK-01 ✅
**Fase spec:** 1

## Tujuan

`php artisan migrate:fresh --seed` ngehasilin: 1 akun demo + 25 barang gadai dummy yang realistis (biar demo keliatan hidup).

## Instruksi

1. `php artisan make:factory BarangGadaiFactory --model=BarangGadai`
2. Factory harus realistis konteks Indonesia, jangan lorem ipsum:
   - `nama_barang`: pilih acak dari daftar riil — elektronik: "iPhone 13 128GB", "Laptop ASUS VivoBook 14", "TV LED Samsung 43 inch", "PS5", "Kamera Canon EOS M50", dst; kendaraan: "Honda Beat 2021", "Yamaha NMAX 2022", "Honda Vario 125 2020", "Suzuki Nex II 2023", dst. **Kategori harus nyambung sama nama barangnya** (jangan sampai "Honda Beat" kategorinya elektronik).
   - `taksiran_nilai`: elektronik 500rb–15jt, kendaraan 5jt–25jt (angka bulat ratusan ribu).
   - `nama_nasabah`: nama Indonesia (`fake('id_ID')->name()`).
   - `no_hp`: format `08xxxxxxxxxx`.
   - `tanggal_gadai`: acak 6 bulan terakhir.
   - `status`: acak dengan bobot ± aktif 60%, ditebus 25%, lelang 15%.
   - `catatan`: ± 30% terisi (kondisi barang, kelengkapan surat), sisanya null.
3. **Pindahin faker ke dependency produksi:** `composer require fakerphp/faker`. Alasan: seeder ini juga jalan di produksi (data produksi = data demo), sedangkan deploy pakai `composer install --no-dev` — kalau faker tetap di `require-dev`, seed di server bakal crash. Ini pengecualian resmi dari aturan "jangan nambah package" di 01-CARA-KERJA (package-nya udah ada, cuma pindah section).
4. `DatabaseSeeder`:
   - User demo: name `Petugas Demo`, email `demo@sigadai.my.id`, password `sigadai123`. **Hapus seed user `test@example.com` bawaan Laravel** — jangan sampai akun default ketebak hidup di produksi.
   - Biar tiap status & kategori PASTI ada (bukan untung-untungan random): bikin 6 record eksplisit dulu lewat factory state (kombinasi 3 status × 2 kategori), lalu `BarangGadai::factory(19)->create();` → total 25.
   - Idempotent-ish: pakai `User::factory()->create([...])` biasa aja — seeder memang diasumsikan jalan setelah `migrate:fresh`.

## Kriteria selesai

- [x] `php artisan migrate:fresh --seed` sukses
- [x] Tinker: `App\Models\BarangGadai::count()` → 25
- [x] Tinker: ada minimal 1 record per status (`aktif`, `ditebus`, `lelang`) dan per kategori
- [x] Bisa login di browser pakai `demo@sigadai.my.id` / `sigadai123`
- [x] Spot-check: nama barang nyambung sama kategorinya

## Jangan

- Jangan seed ratusan data — 25 cukup.

## Commit

`TASK-02: factory + seeder dummy + akun demo`
