# 01 — Cara Kerja (aturan buat AI agent yang ngelanjutin)

Lu (agent) ngelanjutin projek yang skeleton-nya udah di-setup. Ikutin aturan ini persis.

## Urutan task

Kerjain **berurutan** dari TASK-01 sampai TASK-10. Jangan loncat, kecuali satu pengecualian di bawah.

| # | Task | Status |
|---|---|---|
| 01–08 | Fondasi + fitur (migration → polish) | ✅ semua selesai |
| 09 | [Deploy VPS Biznet](tasks/TASK-09-deploy-vps.md) | ✅ live via GitHub Actions |
| 11–14 | Batch perbaikan review (auto-reset, jatuh tempo, dashboard, CI/CD) | ✅ semua selesai |
| 10 | [README + bukti](tasks/TASK-10-readme-bukti.md) | ✅ (video demo masih nunggu Dier) |
| **15** | [Kebijakan MySQL-only](tasks/TASK-15-mysql-only.md) | ⬜ **mulai dari sini** |
| **16** | [Badge jatuh tempo derived + tuning seeder](tasks/TASK-16-badge-jatuh-tempo-derived.md) | ⬜ setelah 15 |

TASK-11 s/d 14 lahir dari review kode 2026-07-15, TASK-15 dari keputusan dev/prod parity, TASK-16 dari temuan UX Dier — konteksnya ada di masing-masing file task. Ide di luar scope diparkir di [NANTI.md](NANTI.md).

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
- **DB = MySQL di SEMUA lingkungan** (kebijakan MySQL-only). Test pakai DB khusus `sigadai_test` — JANGAN arahin test ke DB dev, `RefreshDatabase` bakal ngehapus isinya. Tetap prefer Eloquent/query builder ketimbang raw SQL.
- Ada ambiguitas yang ngefek ke keputusan produk → **tanya Dier**, jangan ngarang.

## Cara verifikasi manual

```bash
php artisan serve          # buka http://localhost:8000
php artisan migrate:fresh --seed   # reset + isi ulang data dummy
npm run build              # kalau ubah css/js (atau `npm run dev` selama develop)
```

Login pakai akun demo: `demo@sigadai.my.id` / `sigadai123`.
