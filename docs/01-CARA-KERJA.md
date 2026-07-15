# 01 — Cara Kerja (aturan buat AI agent yang ngelanjutin)

Lu (agent) ngelanjutin projek yang skeleton-nya udah di-setup. Ikutin aturan ini persis.

## Urutan task

Kerjain **berurutan** dari TASK-01 sampai TASK-10. Jangan loncat, kecuali satu pengecualian di bawah.

| # | Task | Status |
|---|---|---|
| 01–08 | Fondasi + fitur (migration → polish) | ✅ semua selesai |
| 09 | [Deploy VPS Biznet](tasks/TASK-09-deploy-vps.md) | ✅ live via GitHub Actions |
| **11** | [Auto-reset data demo](tasks/TASK-11-auto-reset-demo.md) | ⬜ **mulai dari sini** |
| **12** | [Jatuh tempo DB-agnostic](tasks/TASK-12-jatuh-tempo-db-agnostic.md) | ⬜ setelah 11 |
| **13** | [Konsistensi angka dashboard](tasks/TASK-13-dashboard-konsisten.md) | ⬜ setelah 12 |
| **14** | [Hardening CI/CD](tasks/TASK-14-cicd-hardening.md) | ⬜ setelah 13 |
| 10 | [README + bukti](tasks/TASK-10-readme-bukti.md) | ⬜ paling akhir (biar screenshot final) |

TASK-11 s/d 14 lahir dari review kode menyeluruh 2026-07-15 — konteks temuannya ada di masing-masing file task.

## Ritual per task

1. Baca [00-KONTEKS-PROJEK.md](00-KONTEKS-PROJEK.md) (sekali di awal sesi).
2. Baca file task-nya. Kerjain **cuma** yang ada di situ.
3. Verifikasi tiap item "Kriteria selesai" — jalanin beneran, jangan diasumsikan.
4. Update status di file task: `⬜ Belum` → `✅ Selesai`.
5. Commit dengan format `TASK-XX: <ringkasan>` lalu `git push`.

## Aturan keras

- ⚠️ **PUSH KE `main` = DEPLOY PRODUKSI OTOMATIS.** GitHub Actions ([deploy.yml](../.github/workflows/deploy.yml)) langsung SSH ke VPS dan jalanin `migrate --force` ke DB live tiap push. Jangan pernah push migration/kode setengah jadi. Kerjain sampai teruji lokal, baru push sekali.
- **Jangan pernah edit migration yang udah ke-push.** Perubahan skema = migration baru. (Pelanggaran pertama udah kejadian di commit `eecd987` — jangan diulang.)
- **Scope dikunci.** Fitur di luar task = tulis ke `docs/NANTI.md` (bikin kalau belum ada), jangan dikerjain. Termasuk: jangan nambah package composer/npm baru tanpa disuruh task.
- **Jangan refactor** kode yang bukan bagian task lu.
- **Bahasa UI = Indonesia.** Label tombol, judul halaman, pesan validasi: semua Indonesia.
- **Konsisten sama Breeze.** Pakai layout `x-app-layout` dan komponen Blade bawaan Breeze (`x-input-label`, `x-text-input`, `x-primary-button`, `x-input-error`) biar seragam. Jangan bikin sistem komponen sendiri.
- Format Rupiah pakai helper: `'Rp ' . number_format($nilai, 0, ',', '.')`.
- **Kode wajib jalan di MySQL DAN SQLite.** `.env` lokal sekarang MySQL (sah), tapi `phpunit.xml` & `.env.example` pakai SQLite — jangan pakai raw SQL spesifik-vendor.
- Ada ambiguitas yang ngefek ke keputusan produk → **tanya Dier**, jangan ngarang.

## Cara verifikasi manual

```bash
php artisan serve          # buka http://localhost:8000
php artisan migrate:fresh --seed   # reset + isi ulang data dummy
npm run build              # kalau ubah css/js (atau `npm run dev` selama develop)
```

Login pakai akun demo: `demo@sigadai.my.id` / `sigadai123`.
