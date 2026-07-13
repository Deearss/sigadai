# TASK-06: Dashboard 3 kartu ringkasan

**Status:** ⬜ Belum
**Prasyarat:** TASK-05 ✅
**Fase spec:** 3

## Tujuan

`/dashboard` (bawaan Breeze, sekarang isinya cuma "You're logged in!") diganti jadi 3 kartu angka dari data beneran.

## Instruksi

1. Bikin controller ringan: `php artisan make:controller DashboardController` dengan method `__invoke`, ganti route `/dashboard` bawaan Breeze supaya lewat controller ini (tetap middleware `auth`).
2. Data yang dihitung:
   - **Kartu 1 — Barang Aktif:** `BarangGadai::where('status', 'aktif')->count()`
   - **Kartu 2 — Total Taksiran Aktif:** `BarangGadai::where('status', 'aktif')->sum('taksiran_nilai')` → format Rupiah
   - **Kartu 3 — Barang per Kategori:** count per kategori (elektronik: X · kendaraan: Y). Satu query aja: `BarangGadai::select('kategori')->selectRaw('count(*) as total')->groupBy('kategori')->pluck('total', 'kategori')`
3. Update `resources/views/dashboard.blade.php`: grid 3 kartu (responsive: 1 kolom di mobile, 3 di desktop), tiap kartu ada label + angka gede + ikon/aksen warna sederhana.
4. Tambahin link "Kelola Barang →" di bawah kartu, ke `barang.index`.

## Kriteria selesai

- [ ] Angka kartu cocok sama data seeder (cross-check pakai tinker)
- [ ] `php artisan migrate:fresh` TANPA seed → dashboard tetap kebuka, angka 0 dan `Rp 0`, nggak error (abis ngetes, balikin: `migrate:fresh --seed`)
- [ ] Responsive: 1 kolom di layar sempit

## Jangan

- Jangan bikin chart/grafik. Jangan install library chart. Angka doang.

## Commit

`TASK-06: dashboard 3 kartu ringkasan`
