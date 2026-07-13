# TASK-01: Migration + Model `BarangGadai`

**Status:** ⬜ Belum
**Prasyarat:** — (task pertama)
**Fase spec:** 1

## Tujuan

Tabel `barang_gadai` ada di DB, model `BarangGadai` siap dipakai.

## Instruksi

1. `php artisan make:model BarangGadai -m`
2. Migration — kolom persis sesuai [data model di 00-KONTEKS](../00-KONTEKS-PROJEK.md#data-model):
   ```php
   $table->id();
   $table->string('nama_barang');
   $table->enum('kategori', ['elektronik', 'kendaraan']);
   $table->decimal('taksiran_nilai', 15, 2);
   $table->string('nama_nasabah');
   $table->string('no_hp');
   $table->date('tanggal_gadai');
   $table->enum('status', ['aktif', 'ditebus', 'lelang'])->default('aktif');
   $table->text('catatan')->nullable();
   $table->timestamps();
   ```
3. Model `app/Models/BarangGadai.php`:
   - `protected $table = 'barang_gadai';` (nama tabel nggak jamak, wajib eksplisit)
   - `$fillable` semua kolom kecuali id/timestamps
   - `$casts`: `tanggal_gadai` => `date`, `taksiran_nilai` => `decimal:2`
   - Konstanta biar nggak ada magic string nyebar:
     ```php
     public const KATEGORI = ['elektronik', 'kendaraan'];
     public const STATUS = ['aktif', 'ditebus', 'lelang'];
     ```
4. `php artisan migrate`

## Kriteria selesai

- [ ] `php artisan migrate` sukses tanpa error
- [ ] `php artisan tinker --execute="App\Models\BarangGadai::create(['nama_barang'=>'Tes','kategori'=>'elektronik','taksiran_nilai'=>1000000,'nama_nasabah'=>'Tes','no_hp'=>'08123','tanggal_gadai'=>'2026-07-01'])->status"` → output `aktif` (default jalan)
- [ ] Hapus data tes tadi (`BarangGadai::truncate()` via tinker)

## Jangan

- Jangan bikin tabel nasabah terpisah. Jangan bikin relasi apapun.

## Commit

`TASK-01: migration + model BarangGadai`
