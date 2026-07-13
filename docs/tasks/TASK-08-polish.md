# TASK-08: Polish — status badge, empty state, cek validasi

**Status:** ⬜ Belum
**Prasyarat:** TASK-07 ✅
**Fase spec:** 4

## Tujuan

App-nya kelihatan "jadi", bukan tugas kuliah. Ini task terakhir sebelum deploy final.

## Instruksi

1. **Status badge** di kolom status index (ganti teks polos dari TASK-04). Bikin partial/komponen kecil `resources/views/barang/_status-badge.blade.php`:
   - `aktif` → hijau (`bg-green-100 text-green-800`)
   - `ditebus` → abu/biru (`bg-blue-100 text-blue-800`)
   - `lelang` → merah/amber (`bg-red-100 text-red-800`)
   - Bentuk: pill rounded, teks kapital depan ("Aktif").
2. **Badge kategori** (opsional tapi murah): teks kecil ikon 📱/🛵 atau label abu — kalau bikin ribet, skip.
3. **Empty state DB kosong** di index: kalau nggak ada data sama sekali (tanpa filter), tampilkan ilustrasi teks sederhana + tombol "+ Tambah Barang Pertama". (Empty state hasil filter udah dari TASK-07 — dua-duanya harus bisa dibedain.)
4. **Sapuan akhir validasi & UX** — cek dan rapihin:
   - Semua pesan validasi kebaca natural bahasa Indonesia
   - Title tag per halaman ("Barang Gadai — SiGadai", dst)
   - Tanggal tampil konsisten `d/m/Y` di semua tempat
   - Nggak ada teks bawaan Breeze/Laravel yang nyeleneh kelihatan user (misal welcome page, "You're logged in!")
5. `npm run build` final.

## Kriteria selesai

- [ ] 3 status punya badge warna beda, kebaca jelas
- [ ] `migrate:fresh` tanpa seed → index & dashboard tetap oke, empty state muncul (abis itu balikin: `migrate:fresh --seed`)
- [ ] Klik-klik seluruh app 5 menit: nggak nemu error, teks aneh, atau layout patah di mobile width
- [ ] Definition of Done di [00-KONTEKS](../00-KONTEKS-PROJEK.md) poin 2–6 semua ✓ secara lokal

## Jangan

- Jangan redesign layout. Jangan nambah fitur. Polish ≠ fitur baru.

## Commit

`TASK-08: polish — status badge, empty state, UX pass`
