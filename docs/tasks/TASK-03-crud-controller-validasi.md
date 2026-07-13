# TASK-03: Routes + Resource Controller + validasi

**Status:** ✅ Selesai
**Prasyarat:** TASK-02 ✅
**Fase spec:** 2

## Tujuan

Semua route CRUD hidup dan tervalidasi. View-nya belum ada (TASK-04/05) — controller boleh return view yang belum dibikin, yang penting logic-nya kelar.

## Instruksi

1. `php artisan make:controller BarangGadaiController --model=BarangGadai --resource`
2. `php artisan make:request StoreBarangGadaiRequest` dan `UpdateBarangGadaiRequest`.
3. Rules (dua-duanya sama):
   ```php
   'nama_barang'    => ['required', 'string', 'max:255'],
   'kategori'       => ['required', Rule::in(BarangGadai::KATEGORI)],
   'taksiran_nilai' => ['required', 'numeric', 'min:0'],
   'nama_nasabah'   => ['required', 'string', 'max:255'],
   'no_hp'          => ['required', 'string', 'max:20'],
   'tanggal_gadai'  => ['required', 'date'],
   'status'         => ['required', Rule::in(BarangGadai::STATUS)],
   'catatan'        => ['nullable', 'string'],
   ```
   `authorize()` return `true` (semua user login boleh — nggak ada role).
   Pesan error pakai bahasa Indonesia: override `messages()` atau set atribut via `attributes()` — minimal atributnya kebaca natural ("nama barang wajib diisi").
4. Routes di `web.php`, dalam group `auth`:
   ```php
   Route::resource('barang', BarangGadaiController::class)
       ->except(['show'])
       ->middleware('auth');
   ```
   `show` nggak dipakai (detail nggak ada di spec — index udah nampilin semua kolom penting).
5. **Jebakan route model binding (WAJIB dibenerin):** stub dari `make:controller --model` ngasih parameter `$barangGadai`, padahal parameter route-nya `{barang}`. Nama nggak match = implicit binding diam-diam gagal → Laravel inject model KOSONG (form edit blank, update/destroy nggak ngefek tapi tetap redirect "sukses"). Rename semua jadi `$barang`: `edit(BarangGadai $barang)`, `update(UpdateBarangGadaiRequest $request, BarangGadai $barang)`, `destroy(BarangGadai $barang)`.
6. Isi controller:
   - `index`: `BarangGadai::latest()->paginate(10)` → view `barang.index` (search/filter nyusul TASK-07)
   - `create` / `edit`: return view + kirim data yang dibutuhkan
   - `store` / `update`: pakai Form Request, redirect ke `barang.index` dengan flash `session('success')` berisi pesan Indonesia ("Barang gadai berhasil ditambahkan." / "...diperbarui.")
   - `destroy`: delete, redirect + flash ("Barang gadai berhasil dihapus.")
7. Redirect root: ubah route `/` supaya guest diarahkan ke `/login` dan user login ke `/dashboard` (Breeze default udah mirip — pastiin aja nggak nampilin welcome page Laravel).
8. **Matiin registrasi & reset password publik** — spec cuma minta login/logout, user satu-satunya datang dari seeder. Di `routes/auth.php`: hapus/komentari route `register` (GET+POST) dan password reset (`forgot-password`, `reset-password` GET+POST). Hapus juga link "Forgot your password?" di `resources/views/auth/login.blade.php`. Sisakan: login, logout, profile, dan route verifikasi/confirm-password bawaan yang dipakai halaman profile.

## Kriteria selesai

- [x] `php artisan route:list | grep barang` → 6 route muncul (index, create, store, edit, update PUT|PATCH jadi satu baris, destroy) tanpa show
- [x] Edit satu barang via binding beneran ngambil data (bukan model kosong) — cek di tinker atau via form nanti
- [x] `GET /register` dan `GET /forgot-password` → 404
- [x] Semua route `barang.*` mental ke login kalau belum auth (tes pakai curl: dapat 302)
- [x] POST `/barang` dengan body kosong (via tes manual form nanti, atau tinker/HTTP client) → balik dengan error validasi, bukan 500
- [x] `GET /` guest → redirect login

## Jangan

- Jangan bikin API route. Jangan bikin policy/gate — nggak ada role.

## Commit

`TASK-03: routes + controller + validasi CRUD barang gadai`
