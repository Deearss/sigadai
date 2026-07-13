# SiGadai - Rencana Build & Deploy

Mini web app manajemen barang gadai (Laravel). Portofolio bertema bisnis calon employer (Koperasi Syariah, gadai elektronik & kendaraan).

**Target:** ke-deploy, bisa dibuka publik, bisa dipakai, dalam waktu sekitar 1 minggu.
**Nama app:** SiGadai (boleh diganti).

---

## 0. Konteks (kenapa app ini)

Dibikin sebagai bukti portofolio Laravel yang beneran jalan, sekaligus nunjukin ke calon employer (koperasi syariah yang main di gadai) bahwa pelamar udah paham domain bisnis mereka. Secara teknis ini aplikasi inventaris CRUD biasa, cuma temanya barang gadai.

## 1. Prinsip (aturan main, jangan dilanggar)

1. **Ship > sempurna.** Yang penting jadi dan ke-deploy, bukan keren.
2. **Scope dikunci.** Kalau kepikiran fitur baru, tulis di daftar "nanti", jangan dikerjain sekarang.
3. **Deploy duluan, bukan belakangan.** Skeleton kosong di-deploy di awal (Fase 0) biar masalah deployment ketauan dari awal, bukan pas mepet.
4. **Commit tiap fase.** Git dari menit pertama, push ke GitHub tiap selesai satu fase.

## 2. Tech stack

- Laravel (versi stabil terbaru, PHP 8.2+)
- MySQL / MariaDB
- Blade + Tailwind CSS
- Laravel Breeze (auth login/logout, paling ringan)
- Git + GitHub sejak awal

Semua ini persis yang diminta di lowongan.

## 3. Data model

Satu tabel utama saja (sengaja disederhanakan untuk MVP, tanpa tabel nasabah terpisah).

**Tabel: `barang_gadai`**

| Kolom | Tipe | Catatan |
|---|---|---|
| id | bigint (PK) | auto |
| nama_barang | string | wajib |
| kategori | enum | `elektronik`, `kendaraan` |
| taksiran_nilai | decimal(15,2) | nilai taksir dalam Rupiah |
| nama_nasabah | string | wajib |
| no_hp | string | wajib |
| tanggal_gadai | date | wajib |
| status | enum | `aktif`, `ditebus`, `lelang` (default `aktif`) |
| catatan | text | nullable |
| timestamps | | created_at, updated_at |

Plus tabel `users` bawaan Breeze.

## 4. Fitur (IN scope) + kriteria selesai

- [ ] **Auth**: login & logout (Breeze). Halaman non-login diproteksi.
- [ ] **Dashboard**: 3 kartu angka: (1) jumlah barang status `aktif`, (2) total taksiran nilai yang `aktif`, (3) jumlah barang per kategori.
- [ ] **CRUD barang gadai**:
  - Index: tabel daftar barang + pagination.
  - Create & Edit: form dengan validasi (semua field wajib kecuali catatan).
  - Delete: dengan konfirmasi.
- [ ] **Search & filter**: cari by nama barang / nama nasabah; filter by status & kategori.
- [ ] **Status badge**: warna beda tiap status (aktif/ditebus/lelang).
- [ ] **Seeder**: 20-30 data dummy realistis biar demo keliatan hidup.
- [ ] **Akun demo**: 1 user seed (email + password) buat login pas direview.

## 5. Halaman & routes

- `GET /login`, `POST /logout` (Breeze)
- `GET /dashboard` - kartu ringkasan
- `Route::resource('barang', BarangGadaiController::class)` -> index, create, store, edit, update, destroy
- Search & filter lewat query string di halaman index (contoh: `/barang?status=aktif&kategori=elektronik&q=motor`)

Pakai satu resource controller + Blade views + layout Breeze/Tailwind.

## 6. DI LUAR scope (JANGAN dikerjain dulu)

Ini yang bikin projek sebelumnya mangkrak. Semua ini nyusul HANYA kalau core udah ke-deploy:

- Logika angsuran / margin / bunga syariah
- Multi-cabang
- Multi-role / hak akses bertingkat
- Upload foto barang
- Notifikasi WA/email
- Cetak struk / export PDF
- REST API (opsional banget, cuma kalau sisa waktu: 1 endpoint read-only `GET /api/barang`)

## 7. Urutan build (per fase)

- **Fase 0 - Setup & deploy skeleton** (± setengah hari)
  Install Laravel, Breeze, koneksi DB, init Git + push GitHub. Langsung deploy versi kosong ke server (lihat bagian 8). Tujuan: mastiin pipeline deploy jalan dari awal.
- **Fase 1 - Data** (± setengah hari)
  Migration `barang_gadai`, model, seeder dummy + akun demo.
- **Fase 2 - CRUD** (± 1-2 hari)
  Controller resource + Blade views (index, create, edit) + Tailwind + validasi.
- **Fase 3 - Dashboard + search/filter** (± 1 hari)
  Kartu ringkasan + search & filter di index.
- **Fase 4 - Polish + deploy final** (± setengah hari)
  Status badge, empty state, cek validasi, deploy ulang versi final.
- **Fase 5 - Bukti** (± setengah hari)
  Screenshot, rekam video demo 1-2 menit, tulis README (isi: deskripsi, fitur, screenshot, link live, link demo). Push.

## 8. Rencana deploy

**Aturan:** deploy skeleton di Fase 0, bukan di akhir.

**Pilihan utama (disaranin): VPS murah + Ubuntu.**
Alasan: ini SKILL yang diminta lowongan ("Linux Server, deployment") dan yang selama ini lu lemah. Sekali ini dikerjain, lu jadi bisa ngeklaim beneran. Payah dikit di awal, tapi worth.

Langkah VPS (Claude Code bisa bantuin tiap langkah):
1. Sewa VPS murah (Ubuntu 22.04). Lokal ada yang mulai ~Rp30rb-an/bln.
2. SSH masuk, update: `apt update && apt upgrade`.
3. Install stack: Nginx, PHP 8.2-FPM (+ ekstensi: mbstring, xml, curl, mysql, zip, bcmath), MySQL/MariaDB, Composer, Git, Node (buat build Tailwind).
4. Clone repo, `composer install --no-dev`, `npm install && npm run build`.
5. Set `.env` (APP_ENV=production, APP_KEY generate, koneksi DB), `php artisan migrate --seed`.
6. Set permission `storage` & `bootstrap/cache`, `php artisan optimize`.
7. Konfig Nginx (root ke `/public`), arahkan domain/IP, pasang SSL (Let's Encrypt/certbot).
8. (Opsional) domain murah `.my.id` (~Rp10-15rb) biar keliatan pro.

**Fallback (kalau mentok / mepet waktu): Render (free tier).**
Gratis, tapi app "tidur" abis 15 menit nganggur (bangun 30-50 detik) dan Laravel butuh sedikit setup (Dockerfile / env PHP). Buat sekadar link demo portofolio, cukup.

**Aturan keras:** kasih diri lu batas. Kalau deploy VPS belum jalan dalam waktu yang lu tentuin, langsung pindah ke Render biar app tetep KE-SHIP. Ship dulu, rapihin server belakangan.

## 9. Definition of Done (garis finish)

Projek dianggap SELESAI kalau semua ini ✓:

- [ ] Ke-deploy di URL publik yang bisa dibuka siapa aja
- [ ] Bisa login pakai akun demo
- [ ] Bisa create / edit / hapus barang gadai tanpa error
- [ ] Dashboard nampilin angka dari data seeder
- [ ] Search & filter jalan
- [ ] Nggk error pas data kosong (empty state aman)
- [ ] README ada: deskripsi + screenshot + link live + link video demo
- [ ] Repo publik di GitHub, rapi

Kalau 8 ini kelar, projek NAIK KELAS dari "mangkrak" jadi "bukti nyata".

## 10. Prompt pembuka buat Claude Code (copy-paste)

> Gue mau bikin web app Laravel bernama SiGadai: sistem manajemen barang gadai sederhana (portofolio, bertema bisnis koperasi gadai). Ikutin spec di file ini apa adanya, dan kunci scope-nya (jangan nambah fitur di luar daftar IN). Kerjain per fase sesuai urutan (Fase 0 sampai 5), dan deploy skeleton kosong duluan di Fase 0. Stack: Laravel + MySQL + Blade + Tailwind + Breeze. Mulai dari Fase 0: setup project, Breeze, koneksi DB, init Git. Tanya gue kalau ada keputusan yang ambigu.
