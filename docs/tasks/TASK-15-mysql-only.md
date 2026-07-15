# TASK-15: Kebijakan MySQL-only (hapus SQLite total)

**Status:** ⬜ Belum
**Prasyarat:** TASK-14 ✅
**Asal:** keputusan Dier 2026-07-15 — dev & produksi harus sinkron, dua-duanya MySQL. Nggak ada lagi SQLite di projek ini.

## Konteks

Sisa-sisa SQLite yang masih hidup:
- `phpunit.xml:26-27` → `DB_CONNECTION=sqlite` + `DB_DATABASE=:memory:`
- `.env.example:23` → `DB_CONNECTION=sqlite`
- File lokal `database/database.sqlite`

## ⚠️ JEBAKAN UTAMA — baca sebelum ngetik apa pun

Test Laravel pakai trait `RefreshDatabase` = **ngehapus dan rebuild seluruh DB yang dikonfigurasi**. Kalau `phpunit.xml` diarahin ke DB `sigadai` (DB dev), `php artisan test` bakal MUSNAHIN data development. WAJIB pakai database test terpisah: `sigadai_test`.

## Instruksi

1. Bikin DB test di MySQL lokal:
   ```sql
   CREATE DATABASE sigadai_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   (user MySQL yang dipakai `.env` lokal harus punya akses ke DB ini juga.)
2. `phpunit.xml`: ganti env DB jadi:
   ```xml
   <env name="DB_CONNECTION" value="mysql"/>
   <env name="DB_DATABASE" value="sigadai_test"/>
   ```
   (host/user/password ngikut `.env` — cuma connection & database yang di-override.)
3. `.env.example`: `DB_CONNECTION=mysql` + isi placeholder `DB_DATABASE=sigadai`, `DB_USERNAME=`, `DB_PASSWORD=` yang jelas (JANGAN commit kredensial asli).
4. Hapus file lokal `database/database.sqlite` (udah di-gitignore, cukup hapus lokal).
5. Jalanin `php artisan test` → semua hijau via MySQL.

## Kriteria selesai

- [ ] `grep -ri sqlite phpunit.xml .env.example config/` → nol referensi aktif (entri default di `config/database.php` bawaan Laravel boleh tetap ada, yang penting nggak ada yang MAKE)
- [ ] `php artisan test` hijau
- [ ] **Bukti test nggak makan DB dev:** catat `BarangGadai::count()` di DB dev sebelum test, jalanin `php artisan test`, count harus TETAP SAMA
- [ ] App lokal tetap jalan normal (dashboard + CRUD)

## Jangan

- Jangan arahin test ke DB `sigadai`. Jangan commit password MySQL ke repo (publik!).
- Produksi nggak perlu disentuh — udah MySQL dari awal.

## Commit

`TASK-15: MySQL-only — phpunit & .env.example pindah dari SQLite, DB test terpisah`
