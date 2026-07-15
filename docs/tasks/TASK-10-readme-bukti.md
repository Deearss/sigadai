# TASK-10: README + bukti portofolio

**Status:** ✅ Selesai — dengan catatan: screenshot asli diambil & di-commit belakangan (2026-07-15, dari situs live), **video demo masih kosong** (README nulis "menyusul"; direkam manual sama Dier, satu-satunya item Definition of Done yang tersisa).
**Prasyarat:** TASK-11 s/d TASK-14 ✅ (kerjain paling akhir, biar screenshot & angka udah final)
**Fase spec:** 5

## Tujuan

Repo-nya "jualan": orang yang buka GitHub langsung ngerti app-nya apa, kelihatan hidup, dan bisa nyoba sendiri dalam 30 detik.

## Instruksi

1. **Screenshot** (minta Dier ambil, atau pakai browser tool kalau ada): login, dashboard, index barang (dengan filter aktif), form create, badge status kelihatan. Simpan di `docs/screenshots/`, kompres wajar (< 300KB per file).
2. **Video demo 1–2 menit** — INI TUGAS DIER (rekam layar: login → dashboard → tambah barang → cari/filter → edit → hapus). Upload YouTube unlisted / Drive. Agent cukup nyiapin daftar adegan + nempel link-nya pas udah ada.
3. **Tulis ulang `README.md`** (buang bawaan Laravel), struktur:
   - Judul + tagline 1 kalimat + badge tech (Laravel, Tailwind, MySQL)
   - **Link live + akun demo** (email & password demo dipajang jelas di atas)
   - Screenshot 2–3 yang paling menjual
   - Fitur (bullet, singkat)
   - Tech stack & keputusan teknis singkat (kenapa Breeze, kenapa 1 tabel)
   - **CI/CD**: sebutin deploy otomatis via GitHub Actions ke VPS — ini nilai jual gede buat lowongan yang minta skill "Linux Server & deployment"
   - Link video demo
   - Cara jalanin lokal (clone → composer install → cp .env.example → key:generate → migrate --seed → npm install && npm run dev → serve)
   - Konteks: "dibangun sebagai portofolio bertema bisnis gadai syariah"
4. README pakai bahasa Indonesia (target pembacanya HRD/tech lead koperasi lokal).
5. Push, terus cek tampilan README di GitHub (gambar kebaca, link jalan) — repo udah publik, jadi ini yang bakal diliat reviewer.

## Kriteria selesai

- [x] README di GitHub: semua gambar render, link live bisa diklik dan jalan
- [x] Orang asing bisa login ke demo cuma dari baca README
- [x] Definition of Done poin 7–8 ✓ → **PROJEK SELESAI** 🎉

## Jangan

- Jangan nulis README bertele-tele. HRD scan 30 detik.

## Commit

`TASK-10: README + screenshot + link demo`
