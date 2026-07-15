# 00 — Konteks Projek SiGadai

> **Baca file ini duluan sebelum ngerjain task apapun.** Spec lengkap ada di [SPEC-ASLI.md](SPEC-ASLI.md). Aturan kerja ada di [01-CARA-KERJA.md](01-CARA-KERJA.md).

## Apa ini

**SiGadai** = mini web app manajemen barang gadai (Laravel). Portofolio buat ngelamar ke koperasi syariah yang bisnisnya gadai elektronik & kendaraan. Secara teknis ini CRUD inventaris biasa, temanya barang gadai.

**Target:** ke-deploy publik, bisa dipakai, dalam ~1 minggu.

## Prinsip (JANGAN dilanggar)

1. **Ship > sempurna.** Jadi dan ke-deploy > keren.
2. **Scope dikunci.** Fitur baru → tulis di daftar "nanti", jangan dikerjain.
3. **Deploy duluan.** Begitu VPS ready, deploy skeleton dulu sebelum lanjut fitur.
4. **Commit tiap task**, push ke GitHub.

## Stack

| Komponen | Pilihan | Status |
|---|---|---|
| Framework | Laravel 13 (PHP 8.3) | ✅ ter-install |
| Auth | Laravel Breeze (blade stack) | ✅ ter-install |
| Frontend | Blade + Tailwind CSS (via Vite) | ✅ ter-install |
| DB (semua lingkungan) | MySQL 8 — dev, test (`sigadai_test`), produksi. **Kebijakan MySQL-only**, SQLite dihapus (TASK-15) | ✅ |
| Repo | https://github.com/Deearss/sigadai (publik, branch `main`) | ✅ ke-push |
| Deploy | VPS Biznet Ubuntu 24.04, **auto-deploy via GitHub Actions tiap push ke `main`** | ✅ LIVE |
| Domain | **https://sigadai.my.id** (SSL aktif) | ✅ |

> **Kebijakan DB: MySQL-only** (keputusan Dier, 2026-07-15) — dev, test, dan produksi semua MySQL biar sinkron 100%. Test WAJIB pakai DB terpisah `sigadai_test`, JANGAN PERNAH nunjuk ke DB dev (`RefreshDatabase` ngehapus isinya). Tetap prefer Eloquent/query builder ketimbang raw SQL biar maintainable.

## Data model

Satu tabel utama. **Tanpa tabel nasabah terpisah** — nasabah cuma kolom, bukan entitas.

**Tabel `barang_gadai`** (Model: `BarangGadai`)

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint PK | auto |
| nama_barang | string | wajib |
| kategori | enum: `elektronik`, `kendaraan` | wajib |
| taksiran_nilai | unsignedBigInteger | Rupiah bulat, wajib, kelipatan 100 (⚠️ penyimpangan resmi dari SPEC-ASLI yang bilang decimal(15,2)) |
| jangka_waktu | integer, default 30 | lama gadai dalam HARI, wajib di form (kolom tambahan di luar SPEC-ASLI) |
| tanggal_jatuh_tempo | date, nullable, index | dihitung otomatis di model saat saving = tanggal_gadai + jangka_waktu (TASK-12 ✅) |
| nama_nasabah | string | wajib |
| no_hp | string | wajib |
| tanggal_gadai | date | wajib |
| status | enum: `aktif`, `ditebus`, `lelang` | default `aktif` |
| catatan | text | nullable (satu-satunya field opsional) |
| timestamps | | created_at, updated_at |

Plus tabel `users` bawaan Breeze (udah ada).

## User & fitur

**Cuma 1 jenis user:** petugas koperasi (login via Breeze). Nggak ada role/permission bertingkat. Nasabah BUKAN user — cuma data.

**Registrasi publik & reset password DIMATIKAN** (dikerjain di TASK-03): user satu-satunya datang dari seeder. Jangan aktifin lagi route register/forgot-password bawaan Breeze.

Fitur (semua milik user login):
- Dashboard: 3 kartu (jumlah barang `aktif`, total taksiran nilai `aktif`, jumlah barang per kategori)
- CRUD barang gadai (index+pagination, create/edit tervalidasi, delete dengan konfirmasi)
- Search (nama barang / nama nasabah) & filter (status, kategori) via query string
- Status badge berwarna per status

## Akun demo (buat HRD/reviewer)

- Email: `demo@sigadai.my.id`
- Password: `sigadai123`

Di-seed lewat `DatabaseSeeder`. Kredensial ini sengaja dipublikasikan di README.

## DI LUAR scope — JANGAN dikerjain

Angsuran/margin/bunga syariah · multi-cabang · multi-role · upload foto · notifikasi WA/email · cetak struk/PDF · REST API. Kalau kepikiran fitur bagus → tulis di `docs/NANTI.md`, lanjut kerja.

## Yang udah dikerjain (kondisi per 2026-07-15)

- **TASK-01 s/d TASK-08 selesai semua** — CRUD, dashboard, search/filter, polish. Cek git log.
- Di luar task resmi, ada serangkaian commit `TASK-EXTRA` (dikerjain Antigravity bareng Dier): UI di-rombak gaya Shadcn, kolom `jangka_waktu` + konsep "Jatuh Tempo", `taksiran_nilai` jadi integer, proteksi kredensial akun demo.
- **App LIVE di https://sigadai.my.id** — VPS Biznet, deploy otomatis via GitHub Actions ([deploy.yml](../.github/workflows/deploy.yml)): tiap push ke `main` → SSH ke VPS → git pull, composer `--no-dev`, npm build, `migrate --force`, optimize.
- Review menyeluruh 2026-07-15 menghasilkan batch perbaikan **TASK-11 s/d TASK-14** — semuanya udah selesai, plus TASK-10 (README).

**Semua task kode SELESAI (TASK-01 s/d 18, per 2026-07-15) — kode di-freeze.** Fitur baru cuma lewat [NANTI.md](NANTI.md) + approval Dier. Sisa Definition of Done: video demo (manual, Dier).

## Definition of Done (garis finish projek)

- [x] Ke-deploy di URL publik → https://sigadai.my.id
- [x] Bisa login pakai akun demo (diverifikasi live 2026-07-15)
- [x] CRUD barang gadai jalan tanpa error
- [x] Dashboard nampilin angka dari seeder (⚠️ konsistensi angka dibenerin di TASK-13)
- [x] Search & filter jalan
- [x] Nggak error pas data kosong (empty state)
- [ ] README: deskripsi ✅ + screenshot ✅ + link live ✅ + link video demo ← **tinggal video, direkam Dier**
- [x] Repo publik rapi
