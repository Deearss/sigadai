<div>
    <x-input-label for="nama_barang" :value="__('Nama Barang')" />
    <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="kategori" :value="__('Kategori')" />
    <select id="kategori" name="kategori" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
        <option value="" disabled {{ old('kategori', $barang->kategori ?? '') == '' ? 'selected' : '' }}>Pilih Kategori</option>
        @foreach(\App\Models\BarangGadai::KATEGORI as $kat)
            <option value="{{ $kat }}" {{ old('kategori', $barang->kategori ?? '') == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="taksiran_nilai" :value="__('Taksiran Nilai (Rp)')" />
    <x-text-input id="taksiran_nilai" class="block mt-1 w-full" type="number" step="1000" name="taksiran_nilai" :value="old('taksiran_nilai', $barang->taksiran_nilai ?? '')" required />
    <x-input-error :messages="$errors->get('taksiran_nilai')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="nama_nasabah" :value="__('Nama Nasabah')" />
    <x-text-input id="nama_nasabah" class="block mt-1 w-full" type="text" name="nama_nasabah" :value="old('nama_nasabah', $barang->nama_nasabah ?? '')" required />
    <x-input-error :messages="$errors->get('nama_nasabah')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="no_hp" :value="__('No. HP')" />
    <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" placeholder="08xxxxxxxxxx" :value="old('no_hp', $barang->no_hp ?? '')" required />
    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="tanggal_gadai" :value="__('Tanggal Gadai')" />
    <x-text-input id="tanggal_gadai" class="block mt-1 w-full" type="date" name="tanggal_gadai" :value="old('tanggal_gadai', isset($barang) ? $barang->tanggal_gadai->format('Y-m-d') : '')" required />
    <x-input-error :messages="$errors->get('tanggal_gadai')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="status" :value="__('Status')" />
    <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
        <option value="" disabled {{ old('status', $barang->status ?? '') == '' ? 'selected' : '' }}>Pilih Status</option>
        @foreach(\App\Models\BarangGadai::STATUS as $stat)
            <option value="{{ $stat }}" {{ old('status', $barang->status ?? 'aktif') == $stat ? 'selected' : '' }}>{{ ucfirst($stat) }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="catatan" :value="__('Catatan')" />
    <textarea id="catatan" name="catatan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('catatan', $barang->catatan ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
</div>
