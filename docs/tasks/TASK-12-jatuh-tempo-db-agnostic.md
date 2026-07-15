# TASK-12: Hilangkan raw SQL MySQL-only (jatuh tempo → kolom sendiri)

**Status:** ✅ Selesai
**Prasyarat:** TASK-11 ✅
**Asal:** temuan review (blocker) 2026-07-15

## Konteks temuan

Query jatuh tempo pakai raw SQL MySQL-only `whereRaw('DATE_ADD(tanggal_gadai, INTERVAL jangka_waktu DAY) <= ?')` di dua tempat:
- [DashboardController.php:17](../../app/Http/Controllers/DashboardController.php)
- [BarangGadaiController.php:21](../../app/Http/Controllers/BarangGadaiController.php) (filter `?status=jatuh_tempo`)

Di SQLite query ini **crash** (`near "jangka_waktu": syntax error`) — udah direproduksi. Padahal `phpunit.xml` dan `.env.example` pakai SQLite: siapa pun yang clone repo dan buka dashboard dapet 500, dan feature test dashboard mustahil ditulis. Ini juga ngelanggar aturan docs "hindari raw SQL spesifik-vendor".

## Instruksi

1. **Migration BARU** (JANGAN edit migration lama yang udah ke-push — itu udah pernah kejadian di commit `eecd987` dan itu anti-pattern):
   - `$table->date('tanggal_jatuh_tempo')->nullable()->index()` di tabel `barang_gadai`
   - Backfill di migration yang sama, **pakai PHP, bukan raw SQL** (biar jalan di MySQL & SQLite):
     ```php
     DB::table('barang_gadai')->orderBy('id')->chunkById(100, function ($rows) {
         foreach ($rows as $row) {
             DB::table('barang_gadai')->where('id', $row->id)->update([
                 'tanggal_jatuh_tempo' => Carbon::parse($row->tanggal_gadai)->addDays($row->jangka_waktu)->toDateString(),
             ]);
         }
     });
     ```
2. Model `BarangGadai`: hitung otomatis tiap simpan, jangan ngandelin controller:
   ```php
   protected static function booted(): void
   {
       static::saving(function (BarangGadai $barang) {
           $barang->tanggal_jatuh_tempo = $barang->tanggal_gadai?->copy()->addDays((int) $barang->jangka_waktu);
       });
   }
   ```
   Tambah cast `'tanggal_jatuh_tempo' => 'date'`.
3. Ganti KEDUA `whereRaw` jadi `->where('tanggal_jatuh_tempo', '<=', today())` (tetap dikombinasikan `where('status', 'aktif')` kayak sekarang).
4. Tambah 1 feature test: login → `GET /dashboard` → assert 200 (ini otomatis ngejaga SQLite compatibility karena phpunit pakai sqlite :memory:).
5. Verifikasi dual-DB lokal: jalanin `migrate:fresh --seed` + buka dashboard & `/barang?status=jatuh_tempo` di **MySQL** DAN **SQLite** (`touch database/database.sqlite`, override `DB_CONNECTION=sqlite`).

## ⚠️ Peringatan produksi

Push ke `main` = auto-deploy + `php artisan migrate --force` di produksi (lihat 01-CARA-KERJA). Migration + backfill WAJIB udah teruji di MySQL lokal sebelum push. Jangan push setengah jadi.

## Kriteria selesai

- [x] Angka "Jatuh Tempo" di dashboard SAMA sebelum vs sesudah refactor (cross-check tinker sebelum mulai: catat angkanya)
- [x] `/dashboard` dan `/barang?status=jatuh_tempo` jalan di SQLite tanpa error
- [x] `php artisan test` hijau (termasuk test dashboard baru)
- [x] Grep `whereRaw` di app/ → nol hasil (atau sisa yang DB-agnostic doang)
- [x] Setelah push: cek Actions hijau + dashboard live masih bener angkanya

## Jangan

- Jangan edit migration lama. Jangan ubah definisi bisnis jatuh tempo (tetap: `tanggal_gadai + jangka_waktu hari` udah lewat & status masih aktif).

## Commit

`TASK-12: kolom tanggal_jatuh_tempo + query DB-agnostic (fix crash SQLite)`
