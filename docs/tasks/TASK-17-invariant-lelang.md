# TASK-17: Invariant lelang — barang cuma boleh dilelang setelah jatuh tempo

**Status:** ✅ Selesai
**Prasyarat:** TASK-16 ✅
**Asal:** temuan Dier 2026-07-15 — filter "Lelang" nampilin barang yang masih "Sisa 20 Hari". Secara domain mustahil: lelang = konsekuensi nasabah gagal nebus SETELAH jatuh tempo.

## Aturan domain (kunci ini di kepala)

- `lelang` ⇒ WAJIB udah lewat jatuh tempo (`tanggal_gadai + jangka_waktu` < hari ini).
- `ditebus` boleh kapan aja (nebus lebih awal itu normal) — JANGAN dikasih constraint serupa.
- Akar masalah: [BarangGadaiFactory.php:36-44](../../database/factories/BarangGadaiFactory.php) ngundi status terpisah dari tanggal; perlakuan tanggal khusus cuma ada buat `aktif`.

## Instruksi

1. **Factory:** kalau status hasil undian = `lelang`, paksa tanggalnya udah lewat tempo. Cara paling gampang: `tanggal_gadai` = mundur `jangka_waktu + fake()->numberBetween(10, 90)` hari dari hari ini → dijamin `tanggal_jatuh_tempo` udah lewat, dengan variasi telat 10–90 hari (realistis, ada masa tenggang sebelum lelang).
2. **Seeder:** 2 record lelang eksplisit di [BarangGadaiSeeder](../../database/seeders/BarangGadaiSeeder.php) juga harus penuhin invariant yang sama (jangan cuma ngandelin factory default kalau di-override).
3. **Validasi form** (Store + Update Request): tambah rule — kalau `status == lelang`, `tanggal_gadai + jangka_waktu` harus sudah lewat. Pakai `withValidator`/closure rule. Pesan Indonesia yang ngejelasin domainnya, contoh: *"Status lelang hanya untuk barang yang sudah melewati jatuh tempo."* Ini nutup jalur input manual petugas yang bisa menciptakan data mustahil yang sama.
4. Jalanin `migrate:fresh --seed` + `php artisan demo:reset` buat regenerate data.

## Kriteria selesai

- [x] Filter `?status=lelang` → SEMUA kartu progress bar-nya "Jatuh Tempo!", nol yang "Sisa X Hari" (cek lokal + live setelah deploy)
- [x] Tinker: `BarangGadai::where('status','lelang')->where('tanggal_jatuh_tempo','>=',today())->count()` → 0
- [x] Form: submit barang status lelang dengan tanggal gadai kemarin + jangka 30 hari → ditolak validasi dengan pesan yang jelas
- [x] Form: barang lelang dengan tanggal 3 bulan lalu + jangka 30 hari → diterima
- [x] Barang `ditebus` dengan tanggal recent TETAP diterima (jangan sampe constraint bocor ke ditebus)
- [x] `php artisan test` hijau

## Jangan

- Jangan bikin transisi status otomatis (aktif → lelang) — keputusan lelang tetap manual sama petugas, sistem cuma jaga validitasnya.
- Jangan constraint `ditebus`.

## Commit

`TASK-17: invariant lelang (factory + seeder + validasi form)`
