# TASK-11: Auto-reset data demo (proteksi vandalisme)

**Status:** ⬜ Belum
**Prasyarat:** — (kerjain duluan, prioritas tertinggi batch ini)
**Asal:** temuan review keamanan 2026-07-15

## Konteks temuan

"Protected demo account" sekarang cuma ngunci kredensial ([ProfileController.php:29](../../app/Http/Controllers/ProfileController.php), [PasswordController.php:18](../../app/Http/Controllers/Auth/PasswordController.php)). Data barang gadai TIDAK terlindungi: siapa pun login pakai kredensial demo yang dipublikasikan bisa hapus semua record atau isi teks ofensif — dan itu permanen sampai reseed manual via SSH, karena crontab VPS kosong dan deploy.yml nggak nge-seed. Skenario horor: orang iseng ngosongin data jam 9 pagi, HRD buka jam 10.

Kabar baik: `fakerphp/faker` udah di `require` (bukan require-dev), jadi seeder aman jalan di produksi.

## Instruksi

1. Ekstrak seeding barang dari `DatabaseSeeder` ke seeder terpisah `database/seeders/BarangGadaiSeeder.php` (isi: record eksplisit per status/kategori + factory, persis logic yang sekarang). `DatabaseSeeder` tinggal `$this->call(BarangGadaiSeeder::class)` — perilaku `migrate:fresh --seed` nggak boleh berubah.
2. Bikin command `php artisan make:command ResetDemoData` — signature `demo:reset`:
   - `BarangGadai::truncate();`
   - Jalanin `BarangGadaiSeeder` (via `$this->call()` di Artisan atau `Artisan::call('db:seed', ['--class' => ..., '--force' => true])`)
   - **JANGAN sentuh tabel `users`/`sessions`** — user yang lagi login nggak boleh ke-logout, akun demo nggak boleh keganggu.
3. Daftarin schedule di `routes/console.php`:
   ```php
   Schedule::command('demo:reset')->hourly();
   ```
4. Aktifin scheduler di VPS (butuh SSH — koordinasi sama Dier kalau lu nggak punya akses):
   ```bash
   crontab -e
   # tambahin:
   * * * * * cd /var/www/sigadai && php artisan schedule:run >> /dev/null 2>&1
   ```

## Kriteria selesai

- [ ] Lokal: hapus beberapa barang manual → `php artisan demo:reset` → data balik lengkap (25 record, semua status/kategori ada), user demo tetap bisa login tanpa logout
- [ ] `php artisan schedule:list` nampilin `demo:reset` hourly
- [ ] `php artisan migrate:fresh --seed` masih ngehasilin hasil yang sama kayak sebelumnya
- [ ] Di VPS: cron kepasang, lalu `php artisan schedule:run` manual sekali buat mastiin jalan tanpa error
- [ ] Situs live dicek setelah reset: data demo utuh, login demo tetap jalan

## Jangan

- Jangan pakai `migrate:fresh` di command reset — itu ngedrop SEMUA tabel termasuk sessions/users (semua orang ke-logout, race condition sama request aktif).
- Jangan ubah kredensial demo.

## Commit

`TASK-11: auto-reset data demo tiap jam (command + scheduler + cron VPS)`
