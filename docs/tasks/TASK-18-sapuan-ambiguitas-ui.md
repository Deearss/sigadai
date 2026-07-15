# TASK-18: Sapuan ambiguitas UI (hasil exploratory testing 2026-07-15)

**Status:** ⬜ Belum
**Prasyarat:** TASK-17 ✅
**Asal:** exploratory testing Claude di situs live (semua filter + kombinasi + mobile). Semua temuan di bawah udah diverifikasi ke kode (file:line dicantumin). Kerjain berurutan A → H.

## A. SATU kosakata status di semua tempat 🔑 (paling penting)

**Masalah:** app sekarang ngomong 2 bahasa. Badge pakai *status tampilan* (Aktif = belum telat, 7 barang), tapi filter & dashboard pakai *status DB* (Aktif = 16, termasuk 9 yang telat). Akibat: pilih filter "Aktif" → muncul kartu-kartu ber-badge merah "jatuh tempo". Dropdown-nya juga naro "Aktif" dan "Jatuh Tempo" sejajar padahal yang satu subset yang lain ([BarangGadaiController.php:19-26](../../app/Http/Controllers/BarangGadaiController.php), [index.blade.php:71-77](../../resources/views/barang/index.blade.php)).

**Keputusan desain:** seluruh UI pakai kosakata TAMPILAN — 4 kategori disjoint: **Aktif (belum tempo) / Jatuh Tempo / Ditebus / Lelang**. Kolom DB tetap 3 status, nggak berubah.

1. Filter `?status=aktif` → `where('status','aktif')->where('tanggal_jatuh_tempo','>',today())` (filter `jatuh_tempo` udah bener, biarin).
2. Dashboard: kartu "Barang Aktif" = angka aktif-belum-tempo aja (hapus subteks "termasuk X jatuh tempo" — udah nggak perlu). Kartu Jatuh Tempo tetap.
3. Chart "Distribusi Status Barang" → 4 segmen tampilan (Aktif, Jatuh Tempo, Ditebus, Lelang). Tetap WAJIB: jumlah segmen = Total Barang.
4. Ini penyimpangan resmi dari definisi kartu di TASK-06/13 (evolusi produk setelah ada konsep jatuh tempo) — kalau ragu, konfirmasi Dier dulu.

**Kriteria:** count(filter Aktif) + count(filter Jatuh Tempo) = angka DB status aktif; filter Aktif nggak nampilin satu pun badge "jatuh tempo"; chart 4 segmen sum = Total.

## B. Bar barang lelang jangan teriak "Jatuh Tempo!"

**Masalah:** nggak ada branch `lelang` di logika bar ([index.blade.php:235-250](../../resources/views/barang/index.blade.php)) → barang lelang dapet bar merah "Jatuh Tempo!" = alarm "butuh tindakan" padahal tindakannya (lelang) udah diambil. `ditebus` udah punya branch "Selesai" — `lelang` belum.

**Fix:** branch `lelang` → label **"Dilelang"**, bar warna netral gelap (mis. `bg-gray-600`), persen 100.

## C. Warna badge lelang vs jatuh tempo nyaris kembar

**Masalah:** `lelang` = `bg-red-200`, `jatuh_tempo` = `bg-red-100` ([_status-badge.blade.php](../../resources/views/barang/_status-badge.blade.php)) — dua kondisi beda makna (masih bisa ditebus vs udah dieksekusi) keliatan sama.

**Fix:** `jatuh_tempo` tetap merah; `lelang` ganti jelas beda, mis. `bg-amber-200 text-amber-900` (deviasi sadar dari TASK-08 yang bilang lelang merah — merah sekarang jatah jatuh tempo).

## D. Urutan daftar acak tiap reseed

**Masalah:** `latest()` doang ([BarangGadaiController.php:28](../../app/Http/Controllers/BarangGadaiController.php)) — semua data seeder `created_at`-nya identik → MySQL bebas milih urutan → daftar keliatan acak & berubah-ubah.

**Fix:** tambah tie-break `->orderByDesc('id')` setelah `latest()`.

## E. Bar ngitung tanggal tempo manual

**Masalah:** blade ngitung `$tglGadai->addDays($jangka_waktu)` sendiri ([index.blade.php:225-227](../../resources/views/barang/index.blade.php)) padahal kolom `tanggal_jatuh_tempo` udah ada (TASK-12). Duplikasi logika = bisa drift diam-diam.

**Fix:** pakai `$barang->tanggal_jatuh_tempo` langsung.

## F. Placeholder "No Image" di app tanpa fitur foto

**Masalah:** tiap kartu punya kotak "No Image" — fitur foto emang di luar scope, jadi ini bikin app keliatan rusak/datanya bolong, dan makan hampir setengah tinggi kartu di mobile.

**Fix:** ganti kotak gambar jadi ikon kategori sederhana (SVG: device buat elektronik, motor buat kendaraan) dengan background lembut. JANGAN bikin fitur upload.

## G. Sapuan copy

- Tagline "…melalui sistem cerdas kami" → nggak ada yang "cerdas", klaim kosong di depan reviewer teknis. Ganti jujur: mis. "Kelola, pantau, dan temukan seluruh data barang gadai di satu tempat."
- Label "COMMAND CENTER" (+ teks "Sembunyikan Command Center", catatan pagination) → UI-nya Indonesia semua, ini nyelip Inggris. Ganti "Panel Kontrol" (konsisten di semua tempat) & sederhanain catatan footer pagination.

## H. Hint kelipatan Rp100 di form

**Masalah:** aturan `multiple_of:100` baru ketahuan pas error. **Fix:** tambah helper text kecil di bawah field Taksiran Nilai ([_form.blade.php:24-32](../../resources/views/barang/_form.blade.php)): "Kelipatan Rp100".

## (Opsional, skip kalau ribet) I. URL filter kosong

Submit form filter ngehasilin `?q=&status=&kategori=` (param kosong nempel di URL). Bersihin via JS kecil pas submit — murni kosmetik.

## Kriteria selesai keseluruhan

- [ ] Semua kriteria per-item di atas
- [ ] `php artisan test` hijau
- [ ] Setelah deploy: ulangi skenario — filter Aktif (nol badge merah), filter Lelang (semua bar "Dilelang"), cek chart sum = total, cek mobile 375px
- [ ] `migrate:fresh --seed` + `demo:reset` masih jalan normal

## Jangan

- Jangan ubah skema DB / enum status. Jangan bikin fitur upload foto. Jangan redesign layout — ini sapuan konsistensi, bukan rombakan.

## Commit

`TASK-18: sapuan ambiguitas UI (kosakata status, bar lelang, badge, urutan, ikon kategori, copy)`
