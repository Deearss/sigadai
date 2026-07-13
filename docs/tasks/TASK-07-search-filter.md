# TASK-07: Search & filter di index

**Status:** ⬜ Belum
**Prasyarat:** TASK-06 ✅
**Fase spec:** 3

## Tujuan

Index bisa dicari & difilter via query string, contoh: `/barang?status=aktif&kategori=elektronik&q=motor`.

## Instruksi

1. Update `BarangGadaiController@index`:
   ```php
   $barang = BarangGadai::query()
       ->when($request->q, fn ($query, $q) => $query->where(fn ($w) =>
           $w->where('nama_barang', 'like', "%{$q}%")
             ->orWhere('nama_nasabah', 'like', "%{$q}%")))
       ->when($request->status, fn ($query, $s) => $query->where('status', $s))
       ->when($request->kategori, fn ($query, $k) => $query->where('kategori', $k))
       ->latest()
       ->paginate(10)
       ->withQueryString();   // WAJIB: biar filter nggak ilang pas pindah halaman
   ```
   Nilai `status`/`kategori` di luar enum: cukup diabaikan efeknya (nggak match apa-apa) — nggak perlu validasi khusus, tapi JANGAN sampai 500.
2. UI di atas tabel index, satu `<form method="GET">`:
   - Input text `q` placeholder "Cari nama barang / nasabah..."
   - Select `status`: Semua Status / Aktif / Ditebus / Lelang
   - Select `kategori`: Semua Kategori / Elektronik / Kendaraan
   - Tombol "Cari" + link "Reset" ke `/barang`
   - Semua input harus **nampilin nilai aktif dari query string** (pakai `request('q')` dll) biar state-nya kelihatan.
3. Hasil kosong: tampilkan pesan "Tidak ada barang yang cocok dengan pencarian." (empty state versi filter — beda sama empty state DB kosong di TASK-08).

## Kriteria selesai

- [ ] `?q=` nyari di nama barang DAN nama nasabah
- [ ] Kombinasi q + status + kategori jalan bareng
- [ ] Pindah halaman pagination → filter tetap kepasang (cek URL)
- [ ] Filter tanpa hasil → pesan empty, bukan tabel kosong ngeblank
- [ ] `?status=ngaco` → nggak error 500

## Jangan

- Jangan pakai livewire/alpine auto-submit. Submit biasa aja.

## Commit

`TASK-07: search & filter index barang`
