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
| DB lokal | SQLite (`database/database.sqlite`) | ✅ jalan |
| DB produksi | MySQL 8 | di VPS nanti |
| Repo | https://github.com/Deearss/sigadai (publik, branch `main`) | ✅ ke-push |
| Deploy | VPS Biznet, Ubuntu 22.04 | ⬜ belum disewa Dier |
| Domain | `.my.id` (nama final nunggu Dier beli) | ⬜ belum dibeli |

> **Kenapa lokal SQLite padahal spec bilang MySQL?** MySQL lokal di mesin Dier butuh sudo buat bikin DB. SQLite = zero-friction buat dev, dan kode Laravel-nya identik (cuma beda `.env`). Produksi tetap MySQL sesuai spec. Jangan tulis query yang cuma jalan di salah satu (hindari raw SQL spesifik-vendor).

## Data model

Satu tabel utama. **Tanpa tabel nasabah terpisah** — nasabah cuma kolom, bukan entitas.

**Tabel `barang_gadai`** (Model: `BarangGadai`)

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint PK | auto |
| nama_barang | string | wajib |
| kategori | enum: `elektronik`, `kendaraan` | wajib |
| taksiran_nilai | decimal(15,2) | Rupiah, wajib |
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

## Yang udah dikerjain (kondisi sekarang)

- Laravel 13 + Breeze blade ter-install, Tailwind ke-build, migrasi default jalan (SQLite)
- `APP_NAME=SiGadai`
- Git init, push ke GitHub
- Smoke test lulus: `/` 200, `/login` 200, `/dashboard` tanpa login → redirect 302

**Belum ada satupun kode fitur SiGadai.** Mulai dari [tasks/TASK-01](tasks/TASK-01-migration-model.md).

## Definition of Done (garis finish projek)

- [ ] Ke-deploy di URL publik
- [ ] Bisa login pakai akun demo
- [ ] CRUD barang gadai jalan tanpa error
- [ ] Dashboard nampilin angka dari seeder
- [ ] Search & filter jalan
- [ ] Nggak error pas data kosong (empty state)
- [ ] README: deskripsi + screenshot + link live + link video demo
- [ ] Repo publik rapi
