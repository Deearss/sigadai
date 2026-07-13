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
    <div id="taksiran_preview" class="text-sm text-indigo-600 font-medium mt-1 min-h-[20px]"></div>
    <x-input-error :messages="$errors->get('taksiran_nilai')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="jangka_waktu" :value="__('Jangka Waktu (Hari)')" />
    <select id="jangka_waktu" name="jangka_waktu" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
        <option value="" disabled {{ old('jangka_waktu', $barang->jangka_waktu ?? '') == '' ? 'selected' : '' }}>Pilih Jangka Waktu</option>
        @foreach([30, 60, 90, 120] as $hari)
            <option value="{{ $hari }}" {{ old('jangka_waktu', $barang->jangka_waktu ?? '') == $hari ? 'selected' : '' }}>{{ $hari }} Hari</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('jangka_waktu')" class="mt-2" />
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const taksiranInput = document.getElementById('taksiran_nilai');
        const taksiranPreview = document.getElementById('taksiran_preview');
        
        const formatRupiah = (angka) => {
            if (!angka) return '';
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        };

        if (taksiranInput && taksiranPreview) {
            taksiranPreview.innerText = formatRupiah(taksiranInput.value);
            taksiranInput.addEventListener('input', function(e) {
                taksiranPreview.innerText = formatRupiah(this.value);
            });
        }
    });
</script>
