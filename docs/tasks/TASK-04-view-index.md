# TASK-04: View index (tabel daftar barang + pagination)

**Status:** ⬜ Belum
**Prasyarat:** TASK-03 ✅
**Fase spec:** 2

## Tujuan

Halaman `/barang` nampilin tabel barang gadai, rapi, pakai layout Breeze.

## Instruksi

1. Bikin `resources/views/barang/index.blade.php` pakai `<x-app-layout>` (contoh pola: `resources/views/dashboard.blade.php` bawaan Breeze).
2. Kolom tabel: Nama Barang · Kategori · Taksiran (format Rupiah) · Nasabah · No. HP · Tanggal Gadai (format `d/m/Y`) · Status (teks dulu — badge warna nyusul TASK-08) · Aksi (tombol Edit, Hapus).
3. Header halaman: judul "Barang Gadai" + tombol "+ Tambah Barang" ke `barang.create`.
4. Pagination: `{{ $barang->links() }}` di bawah tabel.
5. Flash message: kalau ada `session('success')`, tampilkan banner hijau di atas tabel.
6. Tambahin link "Barang Gadai" di navigasi Breeze (`resources/views/layouts/navigation.blade.php`), pola sama kayak link Dashboard yang udah ada (termasuk versi mobile/hamburger).
7. Styling Tailwind sederhana: tabel putih, header abu, hover row. Jangan install library tabel.

## Kriteria selesai

- [ ] `/barang` (login) nampilin 10 baris + pagination jalan (klik halaman 2 → data beda)
- [ ] Rupiah keformat: `Rp 5.000.000` bukan `5000000.00`
- [ ] Link navigasi "Barang Gadai" muncul di navbar desktop & mobile, active state jalan
- [ ] Nggak ada error di console browser / log Laravel

## Jangan

- Jangan bikin tombol/fitur sort kolom. Jangan bikin halaman detail (show).

## Commit

`TASK-04: view index barang gadai + pagination + nav link`
