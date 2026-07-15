<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Baris 1: Full width -->
    <div class="md:col-span-2">
        <x-input-label for="nama_barang" class="text-sm font-semibold text-gray-900" :value="__('Nama Barang')" />
        <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang ?? '')" placeholder="Misal: iPhone 13 Pro Max 256GB" required autofocus />
        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
    </div>

    <!-- Baris 2 -->
    <div class="relative z-30">
        <x-input-label for="kategori" class="text-sm font-semibold text-gray-900 mb-1" :value="__('Kategori')" />
        <x-combobox name="kategori" :options="collect(\App\Models\BarangGadai::KATEGORI)->map(fn($k) => ['value' => $k, 'label' => ucfirst($k)])->toArray()" :value="old('kategori', $barang->kategori ?? '')" placeholder="Pilih Kategori" />
        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
    </div>

    <div class="relative z-20">
        <x-input-label for="status" class="text-sm font-semibold text-gray-900 mb-1" :value="__('Status')" />
        <x-combobox name="status" :options="collect(\App\Models\BarangGadai::STATUS)->map(fn($s) => ['value' => $s, 'label' => ucfirst($s)])->toArray()" :value="old('status', $barang->status ?? 'aktif')" placeholder="Pilih Status" />
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <!-- Baris 3 -->
    <div>
        <x-input-label for="taksiran_nilai" class="text-sm font-semibold text-gray-900" :value="__('Taksiran Nilai')" />
        <div class="relative mt-1 rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 font-medium sm:text-sm">Rp</span>
            </div>
            <x-text-input id="taksiran_nilai" class="block w-full pl-10" type="text" name="taksiran_nilai" :value="old('taksiran_nilai', $barang->taksiran_nilai ?? '')" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
        </div>
        <p class="text-xs text-gray-500 mt-1 mb-1">Kelipatan Rp100</p>
        <div id="taksiran_preview" class="text-sm text-indigo-600 font-medium mt-1 min-h-[20px]"></div>
        <x-input-error :messages="$errors->get('taksiran_nilai')" class="mt-2" />
    </div>

    <div class="relative z-10">
        <x-input-label for="jangka_waktu" class="text-sm font-semibold text-gray-900 mb-1" :value="__('Jangka Waktu (Tenor)')" />
        <x-combobox name="jangka_waktu" :options="collect([30, 60, 90, 120])->map(fn($h) => ['value' => $h, 'label' => $h . ' Hari'])->toArray()" :value="old('jangka_waktu', $barang->jangka_waktu ?? '')" placeholder="Pilih Jangka Waktu" />
        <p class="text-xs text-gray-500 mt-1">Lama barang dititipkan sebelum jatuh tempo.</p>
        <x-input-error :messages="$errors->get('jangka_waktu')" class="mt-2" />
    </div>

    <!-- Baris 4 -->
    <div>
        <x-input-label for="nama_nasabah" class="text-sm font-semibold text-gray-900" :value="__('Nama Nasabah')" />
        <x-text-input id="nama_nasabah" class="block mt-1 w-full" type="text" name="nama_nasabah" :value="old('nama_nasabah', $barang->nama_nasabah ?? '')" placeholder="Nama sesuai KTP" required />
        <x-input-error :messages="$errors->get('nama_nasabah')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="no_hp" class="text-sm font-semibold text-gray-900" :value="__('Nomor HP')" />
        <x-text-input id="no_hp" class="block mt-1 w-full" type="tel" name="no_hp" placeholder="08xxxxxxxxxx" :value="old('no_hp', $barang->no_hp ?? '')" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
        <div id="no_hp_preview" class="text-sm text-indigo-600 font-medium mt-1 min-h-[20px]"></div>
        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
    </div>

    <!-- Baris 5 -->
    <div class="relative z-20">
        <x-input-label for="tanggal_gadai" class="text-sm font-semibold text-gray-900 mb-1" :value="__('Tanggal Gadai')" />
        <x-datepicker name="tanggal_gadai" :value="old('tanggal_gadai', isset($barang) ? $barang->tanggal_gadai->format('Y-m-d') : '')" placeholder="Pilih Tanggal" />
        <x-input-error :messages="$errors->get('tanggal_gadai')" class="mt-2" />
    </div>

    <!-- Empty div for alignment if we wanted to balance the grid, but leaving it empty makes the last item flow naturally -->
    <div class="hidden md:block"></div>

    <!-- Baris 6: Full width -->
    <div class="md:col-span-2">
        <x-input-label for="catatan" class="text-sm font-semibold text-gray-900" :value="__('Catatan Tambahan (Opsional)')" />
        <textarea id="catatan" name="catatan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3" placeholder="Misal: Dus box hilang, charger original, lecet pemakaian.">{{ old('catatan', $barang->catatan ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const taksiranInput = document.getElementById('taksiran_nilai');
        const taksiranPreview = document.getElementById('taksiran_preview');
        const hpInput = document.getElementById('no_hp');
        const hpPreview = document.getElementById('no_hp_preview');
        
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

        const formatPhone = (number) => {
            if (!number) return '';
            const cleaned = ('' + number).replace(/\D/g, '');
            const match = cleaned.match(/^(\d{0,4})(\d{0,4})(\d{0,4})(\d{0,3})$/);
            if (match) {
                let parts = [];
                for (let i = 1; i <= 4; i++) {
                    if (match[i]) parts.push(match[i]);
                }
                return parts.join(' - ');
            }
            return cleaned;
        };

        if (taksiranInput && taksiranPreview) {
            taksiranPreview.innerText = formatRupiah(taksiranInput.value);
            taksiranInput.addEventListener('input', function(e) {
                taksiranPreview.innerText = formatRupiah(this.value);
            });
        }

        if (hpInput && hpPreview) {
            hpPreview.innerText = formatPhone(hpInput.value);
            hpInput.addEventListener('input', function(e) {
                hpPreview.innerText = formatPhone(this.value);
            });
        }
    });
</script>
