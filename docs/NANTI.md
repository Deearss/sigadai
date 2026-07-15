# NANTI — Parkiran ide di luar scope

> Sesuai prinsip spec: kepikiran fitur baru → tulis di sini, JANGAN dikerjain sebelum Definition of Done kelar dan Dier eksplisit approve.

## 1. Ujrah / jasa simpan + riwayat pembayaran (usulan Dier, 2026-07-15)

**Ide asli:** field "biaya sewa" di barang gadai + total akumulasi pembayaran yang nempel ke barang.

**Kenapa diparkir:** ini bukan field tambahan, ini modul finansial — butuh tabel `pembayaran` (one-to-many ke barang), CRUD pembayaran, kalkulasi akumulasi, dan mepet banget sama item "DI LUAR scope" spec ("logika angsuran / margin / bunga syariah"). DoD tinggal video demo; ship dulu.

**Catatan domain PENTING kalau jadi dikerjain (v2):** koperasi syariah nggak pakai istilah "biaya sewa/bunga". Akadnya **rahn** (gadai), dan biayanya disebut **ujrah / jasa simpan (mu'nah)** — flat berdasarkan taksiran & periode, BUKAN persentase dari pinjaman (itu yang bikin halal secara akad). Pakai terminologi ini di UI = nilai jual domain knowledge ke employer.

**Sketsa desain kasar (belum final):**
- Tabel `pembayaran_ujrah`: id, barang_gadai_id (FK), tanggal_bayar, jumlah, catatan, timestamps
- Field baru di `barang_gadai`: `tarif_ujrah` (per periode, rupiah bulat)
- Halaman detail barang (route `show` yang selama ini sengaja nggak dipakai) = tempat natural buat riwayat pembayaran
- Total akumulasi = SUM relasi, ditampilkan di kartu index & detail
