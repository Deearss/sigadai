# 01 — Cara Kerja (aturan buat AI agent yang ngelanjutin)

Lu (agent) ngelanjutin projek yang skeleton-nya udah di-setup. Ikutin aturan ini persis.

## Urutan task

Kerjain **berurutan** dari TASK-01 sampai TASK-10. Jangan loncat, kecuali satu pengecualian di bawah.

| # | Task | Fase spec | Prasyarat |
|---|---|---|---|
| 01 | [Migration + Model](tasks/TASK-01-migration-model.md) | 1 | — |
| 02 | [Factory + Seeder + akun demo](tasks/TASK-02-seeder-akun-demo.md) | 1 | 01 |
| 03 | [Routes + Controller + validasi](tasks/TASK-03-crud-controller-validasi.md) | 2 | 02 |
| 04 | [View: index + pagination](tasks/TASK-04-view-index.md) | 2 | 03 |
| 05 | [View: create/edit + delete konfirmasi](tasks/TASK-05-view-form-delete.md) | 2 | 04 |
| 06 | [Dashboard 3 kartu](tasks/TASK-06-dashboard.md) | 3 | 05 |
| 07 | [Search & filter](tasks/TASK-07-search-filter.md) | 3 | 06 |
| 08 | [Polish: badge, empty state, validasi](tasks/TASK-08-polish.md) | 4 | 07 |
| 09 | [Deploy VPS Biznet](tasks/TASK-09-deploy-vps.md) | 0+4 | VPS & domain dibeli Dier |
| 10 | [README + bukti](tasks/TASK-10-readme-bukti.md) | 5 | 08 + 09 |

**Pengecualian (prinsip "deploy duluan"):** begitu Dier bilang VPS + domain udah ready, **hentikan task fitur yang belum mulai** dan kerjain TASK-09 Bagian A (deploy skeleton) dulu. Abis itu balik ke urutan normal. TASK-09 Bagian B (deploy final) tetap nunggu TASK-08 kelar.

## Ritual per task

1. Baca [00-KONTEKS-PROJEK.md](00-KONTEKS-PROJEK.md) (sekali di awal sesi).
2. Baca file task-nya. Kerjain **cuma** yang ada di situ.
3. Verifikasi tiap item "Kriteria selesai" — jalanin beneran, jangan diasumsikan.
4. Update status di file task: `⬜ Belum` → `✅ Selesai`.
5. Commit dengan format `TASK-XX: <ringkasan>` lalu `git push`.

## Aturan keras

- **Scope dikunci.** Fitur di luar task = tulis ke `docs/NANTI.md` (bikin kalau belum ada), jangan dikerjain. Termasuk: jangan nambah package composer/npm baru tanpa disuruh task.
- **Jangan refactor** kode yang bukan bagian task lu.
- **Bahasa UI = Indonesia.** Label tombol, judul halaman, pesan validasi: semua Indonesia.
- **Konsisten sama Breeze.** Pakai layout `x-app-layout` dan komponen Blade bawaan Breeze (`x-input-label`, `x-text-input`, `x-primary-button`, `x-input-error`) biar seragam. Jangan bikin sistem komponen sendiri.
- Format Rupiah pakai helper: `'Rp ' . number_format($nilai, 0, ',', '.')`.
- **DB lokal = SQLite.** Jangan ubah `.env` lokal ke MySQL.
- Ada ambiguitas yang ngefek ke keputusan produk → **tanya Dier**, jangan ngarang.

## Cara verifikasi manual

```bash
php artisan serve          # buka http://localhost:8000
php artisan migrate:fresh --seed   # reset + isi ulang data dummy
npm run build              # kalau ubah css/js (atau `npm run dev` selama develop)
```

Login pakai akun demo: `demo@sigadai.my.id` / `sigadai123`.
