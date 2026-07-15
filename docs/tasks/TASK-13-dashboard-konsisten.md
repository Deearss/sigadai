# TASK-13: Konsistensi angka dashboard (lelang ilang dari chart)

**Status:** ⬜ Belum
**Prasyarat:** TASK-12 ✅
**Asal:** temuan review 2026-07-15

## Konteks temuan

Di [DashboardController.php:31-35](../../app/Http/Controllers/DashboardController.php), `$statusStats` cuma berisi Aktif / Ditebus / Jatuh Tempo — **status `lelang` ilang total** dari chart "Distribusi Status Barang". Seeder menjamin ada barang lelang (~15-20% data), jadi di situs live: jumlah segmen donut ≠ angka "Total Barang" di kartu sebelahnya. Reviewer teliti bakal notice angka nggak nyambung. Selain itu kartu "Barang Aktif" dihitung `aktif − jatuhTempo` — menyimpang diam-diam dari definisi spec ("jumlah barang status aktif") tanpa label yang jelasin.

## Instruksi

1. **Chart distribusi status** = cerminan kolom `status` di DB, titik. Tiga segmen: Aktif (SEMUA yang status aktif), Ditebus, Lelang. Jumlah tiga segmen HARUS = Total Barang. "Jatuh Tempo" itu bukan status DB (dia subset dari aktif) — keluarin dari chart; dia udah punya kartu sendiri.
2. Tambahin warna/legend buat Lelang di [dashboard.blade.php](../../resources/views/dashboard.blade.php) (sekarang warnanya hardcoded 3 doang, sekitar line 157).
3. **Kartu "Barang Aktif"**: balikin definisi = count semua status `aktif` (sesuai spec). Kalau mau tetep nampilin insight jatuh tempo di kartu itu, pakai subteks kecil: "termasuk X jatuh tempo" — yang penting label nggak bohong.
4. Kartu "Jatuh Tempo" tetap kayak sekarang.

## Kriteria selesai

- [ ] Sum semua segmen chart == angka kartu "Total Barang" (cross-check tinker)
- [ ] Barang lelang keliatan di chart dengan warna sendiri
- [ ] "Barang Aktif" == `BarangGadai::where('status','aktif')->count()` (cross-check tinker)
- [ ] Nggak ada dua angka di halaman dashboard yang saling kontradiksi
- [ ] Cek visual di situs live setelah deploy

## Jangan

- Jangan nambah chart baru / metrik baru. Ini task konsistensi, bukan fitur.

## Commit

`TASK-13: chart distribusi status lengkap (aktif/ditebus/lelang) + definisi kartu jujur`
