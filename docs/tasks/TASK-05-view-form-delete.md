# TASK-05: View create/edit + delete dengan konfirmasi

**Status:** ⬜ Belum
**Prasyarat:** TASK-04 ✅
**Fase spec:** 2

## Tujuan

Form tambah & edit barang jalan penuh dengan validasi kelihatan di UI, dan hapus barang selalu lewat konfirmasi.

## Instruksi

1. Bikin `resources/views/barang/create.blade.php` dan `edit.blade.php`. Biar DRY, ekstrak field-field ke partial `resources/views/barang/_form.blade.php` yang dipakai dua-duanya.
2. Field form (pakai komponen Breeze `x-input-label`, `x-text-input`, `x-input-error`):
   - Nama Barang — text
   - Kategori — `<select>`: Elektronik / Kendaraan (loop dari `BarangGadai::KATEGORI`)
   - Taksiran Nilai (Rp) — number, step 1000
   - Nama Nasabah — text
   - No. HP — text, placeholder `08xxxxxxxxxx`
   - Tanggal Gadai — date
   - Status — `<select>` dari `BarangGadai::STATUS` (di create boleh default `aktif`)
   - Catatan — textarea, opsional
3. `old()` value harus jalan di semua field (termasuk select), error per-field muncul di bawah field, label bahasa Indonesia.
4. Tombol: "Simpan" + link "Batal" balik ke index.
5. Delete di halaman index: form `method DELETE` + `onsubmit="return confirm('Yakin hapus barang ini?')"`. Cukup confirm() native browser — jangan bikin modal library.

## Kriteria selesai

- [ ] Tambah barang baru dari UI → muncul di index + flash sukses
- [ ] Submit form kosong → error validasi Indonesia muncul per field, input lain nggak ilang (`old()` jalan)
- [ ] Edit barang → perubahan kesimpen, form pre-filled dengan data lama
- [ ] Klik Hapus → dialog konfirmasi muncul; Cancel = nggak kehapus, OK = kehapus + flash sukses
- [ ] Coba inject nilai kategori ngaco (edit HTML select via devtools) → ditolak validasi

## Jangan

- Jangan pakai Alpine modal / library dialog. Jangan nambah field di luar data model.

## Commit

`TASK-05: form create/edit + delete konfirmasi`
