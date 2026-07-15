# TASK-16: Badge status nampilin kondisi jatuh tempo (derived, BUKAN kolom baru)

**Status:** ⬜ Belum
**Prasyarat:** TASK-15 ✅
**Asal:** temuan Dier 2026-07-15 — di index, ada kartu yang progress bar-nya bilang "Jatuh Tempo!" tapi badge di bawah foto bilang "Aktif". Ambigu buat user.

## Keputusan desain (JANGAN diubah tanpa nanya Dier)

`jatuh tempo` adalah **kondisi turunan**, BUKAN status DB. Enum `status` tetap 3 nilai lifecycle: `aktif`, `ditebus`, `lelang`. Yang berubah cuma **tampilan**: barang aktif yang udah lewat `tanggal_jatuh_tempo` di-render sebagai "Jatuh Tempo".

Alasan (biar nggak tergoda "auto-update kolom status"):
- Nyimpen state turunan = butuh cron harian pengubah status + logika balikin pas diperpanjang = dua sumber kebenaran = desync jenis baru.
- Derived = hitung dari data yang sama kayak progress bar → mustahil beda.
- Perpanjangan gadai (edit `jangka_waktu`/`tanggal_gadai`) otomatis balikin tampilan ke "Aktif" tanpa aksi tambahan.

## Instruksi

1. Model `BarangGadai` — tambah accessor status tampilan:
   ```php
   public function getStatusTampilanAttribute(): string
   {
       if ($this->status === 'aktif'
           && $this->tanggal_jatuh_tempo
           && $this->tanggal_jatuh_tempo->isPast()) {
           return 'jatuh_tempo';
       }
       return $this->status;
   }
   ```
2. Partial badge status (yang dipakai kartu index): render dari `$barang->status_tampilan`, tambah varian **"Jatuh Tempo" merah** (`bg-red-100 text-red-800`, senada sama label "Jatuh Tempo!" di progress bar). "Aktif" hijau sekarang cuma buat yang beneran belum due.
3. Cek tempat lain yang nampilin badge/status mentah (form edit, dsb) — samain pakai `status_tampilan`. Field `<select>` status di form TETAP 3 opsi DB (jatuh_tempo bukan pilihan manual).
4. **Tuning seeder/factory:** proporsi sekarang bikin halaman 1 keliatan "telat semua". Atur `tanggal_gadai` + `jangka_waktu` supaya dari barang aktif, kira-kira 60-70% BELUM jatuh tempo (tanggal_gadai lebih recent), sisanya jatuh tempo. Total tetap 25.
5. Filter `?status=jatuh_tempo` dan dashboard nggak perlu diubah — logikanya udah pakai perhitungan tanggal yang sama.

## Kriteria selesai

- [ ] Nggak ada satu pun kartu yang progress bar-nya "Jatuh Tempo!" tapi badge-nya "Aktif" (scan semua halaman index)
- [ ] Edit barang jatuh tempo → perpanjang `jangka_waktu` → badge langsung balik "Aktif" tanpa aksi lain
- [ ] Filter `?status=jatuh_tempo` hasilnya = kartu-kartu yang badge-nya "Jatuh Tempo"
- [ ] Angka dashboard tetap konsisten (kartu Jatuh Tempo == jumlah badge Jatuh Tempo di index tanpa filter)
- [ ] `php artisan test` hijau
- [ ] Setelah deploy: cek visual di situs live + data hasil seed baru keliatan sehat (mayoritas aktif belum telat)

## Jangan

- Jangan nambah nilai enum `jatuh_tempo` di DB. Jangan bikin cron/command pengubah status. Jangan ubah definisi bisnis jatuh tempo.

## Commit

`TASK-16: badge status derived (jatuh tempo) + tuning proporsi seeder`
