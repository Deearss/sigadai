<x-app-layout>
    <x-slot name="title">Barang Gadai</x-slot>
    <div class="py-12" x-data="{ showCommandCenter: true }">
        <div class="w-full px-4 sm:px-6 lg:px-8 relative">
            <!-- Header Section -->
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Barang Gadai
                </h2>
                <p class="mt-3 text-sm text-gray-500 max-w-2xl mx-auto">Kelola, pantau, dan temukan seluruh data barang gadai dengan mudah melalui sistem cerdas kami.</p>
            </div>

            <!-- Filter Section Wrapper for Scroll Cover -->
            <div class="sticky top-0 z-40 bg-gray-100 transition-all duration-500 ease-in-out overflow-hidden origin-top"
                 :class="showCommandCenter ? 'max-h-[800px] pt-6 -mt-6 mb-6 opacity-100' : 'max-h-0 pt-0 mt-0 mb-0 opacity-0'">
                <!-- Filter Section -->
                <div class="p-5 bg-white border border-gray-200 shadow-xl sm:rounded-xl">
                <!-- Command Center Clock -->
                <div class="flex items-center justify-between mb-5 pb-5 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div id="realtime-clock" class="text-2xl font-mono font-bold text-gray-900 tracking-wider leading-none">--:--:--</div>
                            <div id="realtime-date" class="text-xs font-semibold text-gray-500 mt-1.5 uppercase tracking-widest leading-none">Memuat tanggal...</div>
                        </div>
                    </div>
                    <div class="hidden sm:block text-xs font-medium text-gray-400 uppercase tracking-widest">
                        Command Center
                    </div>
                </div>

                <form method="GET" action="{{ route('barang.index') }}" id="filter-form"
                    class="flex flex-col w-full gap-3 md:flex-row">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <!-- Search Icon -->
                            <svg id="search-icon" class="w-4 h-4 text-gray-400 transition-opacity duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <!-- Spinner Icon -->
                            <svg id="search-spinner" class="absolute w-4 h-4 text-indigo-500 animate-spin opacity-0 transition-opacity duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <x-text-input id="search-input" class="block w-full pl-10 text-sm" type="text" name="q"
                            placeholder="Cari nama barang / nasabah..." value="{{ request('q') }}" autocomplete="off" />
                    </div>

                    <!-- Filters -->
                    @php
                        $statusOptions = [['value' => '', 'label' => 'Semua Status']];
                        foreach (\App\Models\BarangGadai::STATUS as $stat) {
                            $statusOptions[] = ['value' => $stat, 'label' => ucfirst($stat)];
                        }
                        $statusOptions[] = ['value' => 'jatuh_tempo', 'label' => 'Jatuh Tempo'];
                        
                        $kategoriOptions = [['value' => '', 'label' => 'Semua Kategori']];
                        foreach (\App\Models\BarangGadai::KATEGORI as $kat) {
                            $kategoriOptions[] = ['value' => $kat, 'label' => ucfirst($kat)];
                        }
                    @endphp
                    <div class="w-full md:w-48 z-20">
                        <x-combobox name="status" :options="$statusOptions" :value="request('status')" placeholder="Semua Status" :spinOnSelect="true" />
                    </div>
                    <div class="w-full md:w-48 z-10">
                        <x-combobox name="kategori" :options="$kategoriOptions" :value="request('kategori')" placeholder="Semua Kategori" :spinOnSelect="true" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center w-full md:w-auto mt-2 md:mt-0">
                        
                        <a href="{{ route('barang.create') }}"
                            class="inline-flex items-center px-5 py-2.5 ml-auto text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md shadow-sm bg-zinc-900 hover:bg-zinc-800 focus:bg-zinc-800 active:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4 sm:mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="hidden sm:inline">Tambah Barang</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </form>

                <!-- Pagination (Moved to Command Center) -->
                @if ($barangGadai->hasPages())
                    <div id="pagination-container" class="relative mt-4 pt-4 border-t border-gray-100 transition-all duration-500 rounded-xl p-2 -mx-2">
                        <!-- Tooltip Highlight -->
                        <div id="pagination-tooltip" class="hidden md:block absolute top-1/2 -translate-y-1/2 right-52 mr-2 opacity-0 pointer-events-none transition-all duration-500 transform -translate-x-2 z-50">
                            <div class="bg-indigo-600 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-xl whitespace-nowrap">
                                Gunakan navigasi ini untuk melihat data lainnya
                            </div>
                            <!-- Arrow pointing RIGHT -->
                            <div class="absolute top-1/2 -right-1.5 -translate-y-1/2 w-0 h-0 border-t-[6px] border-b-[6px] border-l-[6px] border-t-transparent border-b-transparent border-l-indigo-600"></div>
                        </div>

                        {{ $barangGadai->links() }}
                    </div>
                @endif
                </div>
            </div>

            <!-- Data Cards Section -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                @forelse ($barangGadai as $barang)
                    <div
                        class="overflow-hidden transition-shadow duration-200 bg-white border border-gray-200 shadow-sm sm:rounded-xl hover:shadow-md">
                        <div class="flex flex-col gap-5 p-5 sm:flex-row">
                            <!-- Image & Status -->
                            <div class="flex flex-col w-full gap-1 shrink-0 sm:w-36">
                                <div
                                    class="flex flex-col items-center justify-center overflow-hidden bg-gray-100 border border-gray-200 rounded-lg aspect-square">
                                    <svg class="w-10 h-10 mb-2 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    <span class="text-[10px] font-medium text-gray-400">No Image</span>
                                </div>
                                <div class="w-full">
                                    @include('barang._status-badge', [
                                        'status' => $barang->status,
                                        'class' => 'w-full',
                                    ])
                                </div>
                            </div>

                            <!-- Data Container (Right Side) -->
                            <div class="flex flex-col justify-between flex-1 min-w-0">
                                <!-- Row 1: Item Info & Actions -->
                                <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-start">
                                    <!-- Value & Item Name -->
                                    <div class="min-w-0">
                                        <div
                                            class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">
                                            Taksiran Nilai</div>
                                        <div class="text-2xl font-bold leading-none text-gray-900 truncate">Rp
                                            {{ number_format($barang->taksiran_nilai, 0, ',', '.') }}</div>
                                        <div
                                            class="flex flex-wrap items-center gap-2 mt-2 text-sm font-medium text-gray-600">
                                            <span class="truncate">{{ $barang->nama_barang }}</span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 capitalize whitespace-nowrap">
                                                {{ $barang->kategori }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex flex-row items-center gap-4 pt-2 shrink-0 md:pt-0">
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('barang.edit', $barang) }}"
                                                class="p-2 text-gray-400 transition-colors rounded-md hover:text-indigo-600 hover:bg-indigo-50"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('barang.destroy', $barang) }}" method="POST"
                                                class="inline" id="delete-form-{{ $barang->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="p-2 text-gray-400 transition-colors rounded-md hover:text-red-600 hover:bg-red-50 btn-delete-barang"
                                                    data-form-id="delete-form-{{ $barang->id }}"
                                                    data-barang-name="{{ $barang->nama_barang }}"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="w-full h-px my-4 bg-gray-100"></div>

                                <!-- Row 2: Customer & Date -->
                                <div class="flex flex-col gap-6 sm:flex-row sm:gap-12">
                                    <!-- Customer -->
                                    <div class="sm:w-48 shrink-0">
                                        <div
                                            class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">
                                            Nasabah</div>
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $barang->nama_nasabah }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate">{{ $barang->no_hp }}</div>
                                    </div>

                                    <!-- Date, Tenor & Progress -->
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-2">
                                            Waktu Gadai & Jatuh Tempo</div>

                                        @php
                                            $tglGadai = $barang->tanggal_gadai->startOfDay();
                                            $tglJatuhTempo = $tglGadai->copy()->addDays($barang->jangka_waktu);
                                            $sisaHari = (int) now()->startOfDay()->diffInDays($tglJatuhTempo, false);

                                            $totalHari = $barang->jangka_waktu > 0 ? $barang->jangka_waktu : 1;
                                            $hariBerjalan = $totalHari - $sisaHari;
                                            $persen = min(100, max(0, ($hariBerjalan / $totalHari) * 100));

                                            $bgClass = 'bg-indigo-500';
                                            $textClass = 'text-indigo-600';
                                            if ($barang->status === 'ditebus') {
                                                $bgClass = 'bg-emerald-400';
                                                $textClass = 'text-emerald-600';
                                                $sisaText = 'Selesai';
                                                $persen = 100;
                                            } elseif ($sisaHari <= 0) {
                                                $bgClass = 'bg-red-500';
                                                $textClass = 'text-red-600';
                                                $sisaText = 'Jatuh Tempo!';
                                            } elseif ($sisaHari <= 7) {
                                                $bgClass = 'bg-orange-400';
                                                $textClass = 'text-orange-600';
                                                $sisaText = "Sisa $sisaHari Hari";
                                            } else {
                                                $sisaText = "Sisa $sisaHari Hari";
                                            }
                                        @endphp

                                        <!-- Progress Bar -->
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                                            <div class="{{ $bgClass }} h-1.5 rounded-full"
                                                style="width: {{ $persen }}%"></div>
                                        </div>

                                        <div class="flex flex-row items-center justify-between text-xs">
                                            <div class="text-gray-500">
                                                <span
                                                    class="font-medium text-gray-700">{{ $tglGadai->format('d/m/y') }}</span>
                                            </div>
                                            <div class="font-bold {{ $textClass }}">
                                                {{ $sisaText }}
                                            </div>
                                            <div class="text-gray-500">
                                                <span
                                                    class="font-medium text-gray-700">{{ $tglJatuhTempo->format('d/m/y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($barang->catatan)
                            <div class="px-5 py-3 text-sm text-gray-600 border-t border-gray-100 bg-gray-50/50">
                                <span class="font-medium text-gray-700">Catatan:</span> {{ $barang->catatan }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div
                        class="xl:col-span-2 px-6 py-12 overflow-hidden text-center bg-white border border-gray-200 shadow-sm sm:rounded-xl">
                        @if (\App\Models\BarangGadai::count() === 0)
                            <div class="flex flex-col items-center justify-center">
                                <div class="p-4 mb-4 bg-gray-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </div>
                                <h3 class="mb-1 text-lg font-medium text-gray-900">Belum Ada Data</h3>
                                <p class="max-w-sm mb-4 text-sm text-gray-500">Sistem belum memiliki data barang gadai
                                    satupun. Mulai tambahkan data pertama Anda.</p>
                                <a href="{{ route('barang.create') }}"
                                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md shadow-sm bg-zinc-900 hover:bg-zinc-800">
                                    + Tambah Barang
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mb-3 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500">Tidak ada barang yang cocok dengan filter
                                    pencarian Anda.</p>
                                <a href="{{ route('barang.index') }}"
                                    class="mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-800">Reset
                                    Filter</a>
                            </div>
                        @endif
                    </div>
                @endforelse
            </div>
            
            <!-- Bottom Anchor & Indicator for Scroll Detection -->
            @if ($barangGadai->hasPages())
                <div class="flex flex-col items-center justify-center pt-10 pb-12 text-center">
                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Anda telah mencapai akhir daftar data di halaman ini.</p>
                    <p class="text-xs text-gray-400 mt-1">Gunakan fitur <span class="font-semibold text-gray-500">Navigasi Halaman (Pagination)</span> di Command Center untuk melihat data lainnya.</p>
                </div>
            @endif
            <div id="bottom-anchor" class="h-1 w-full"></div>

            <!-- Toggle Command Center Button -->
            <div class="fixed bottom-6 right-6 z-[90] flex items-center justify-center">
                <button @click="showCommandCenter = !showCommandCenter" 
                        class="peer flex items-center justify-center w-12 h-12 bg-indigo-600 text-white rounded-full shadow-xl hover:bg-indigo-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 relative z-10">
                    <!-- Icon Up (Hide) -->
                    <svg x-show="showCommandCenter" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                    <!-- Icon Down (Show) -->
                    <svg x-show="!showCommandCenter" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                
                <!-- Custom Tooltip -->
                <div class="absolute right-full mr-3 whitespace-nowrap bg-gray-900 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-xl opacity-0 translate-x-2 pointer-events-none transition-all duration-300 peer-hover:opacity-100 peer-hover:translate-x-0 z-0">
                    <span x-text="showCommandCenter ? 'Sembunyikan Command Center' : 'Tampilkan Command Center'"></span>
                    <!-- Arrow pointing right -->
                    <div class="absolute top-1/2 -right-1.5 -translate-y-1/2 w-0 h-0 border-t-[6px] border-b-[6px] border-l-[6px] border-t-transparent border-b-transparent border-l-gray-900"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS Toast Notification System -->
    <div 
        x-data="{ 
            toasts: [],
            addToast(message, type = 'success') {
                const id = Date.now() + Math.random().toString(36).substring(2, 9);
                this.toasts.push({ id, message, type });
                setTimeout(() => { this.removeToast(id) }, 4000);
            },
            removeToast(id) {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }
        }"
        x-init='
            @if(session("success"))
                addToast({!! json_encode(session("success")) !!}, "success");
            @endif
            @if(session("error"))
                addToast({!! json_encode(session("error")) !!}, "error");
            @endif
            
            // Listen for custom events to trigger toasts from JS
            window.addEventListener("notify", e => addToast(e.detail.message, e.detail.type || "success"));
        '
        class="fixed top-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none max-w-sm w-full"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-[-1rem]"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-[-1rem]"
                class="pointer-events-auto flex items-center w-full px-4 py-3 bg-white border border-gray-100 rounded-xl shadow-lg ring-1 ring-black ring-opacity-5"
            >
                <!-- Icon -->
                <div class="flex-shrink-0" x-show="toast.type === 'success'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-50">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="flex-shrink-0" x-show="toast.type === 'error'">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                
                <!-- Text -->
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900" x-text="toast.message"></p>
                </div>
                
                <!-- Close Button -->
                <div class="flex-shrink-0 ml-4 flex">
                    <button @click="removeToast(toast.id)" class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Custom Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" id="delete-modal-backdrop"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-6 transform scale-95 opacity-0 transition-all duration-300" id="delete-modal-content">
            <div class="flex flex-col items-center text-center">
                <!-- Icon -->
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <!-- Text -->
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Barang?</h3>
                <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus data <span id="delete-modal-item-name" class="font-semibold text-gray-800"></span>? Tindakan ini permanen dan tidak dapat dibatalkan.</p>
                
                <!-- Buttons -->
                <div class="flex w-full gap-3">
                    <button type="button" id="btn-cancel-delete" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-1">
                        Batal
                    </button>
                    <button type="button" id="btn-confirm-delete" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 shadow-sm shadow-red-200">
                        Hapus Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // --- Filter Detection Logic ---
        // --- Auto-Submit & Debounce Logic ---
        document.addEventListener('DOMContentLoaded', () => {
            const filterForm = document.getElementById('filter-form');
            const searchInput = document.getElementById('search-input');
            const searchIcon = document.getElementById('search-icon');
            const searchSpinner = document.getElementById('search-spinner');
            
            let debounceTimer;

            if (filterForm) {
                // Restore focus and cursor position if search was active
                if (searchInput && searchInput.value) {
                    searchInput.focus();
                    const val = searchInput.value;
                    searchInput.value = '';
                    searchInput.value = val;
                }

                // Debounce search input
                if (searchInput) {
                    searchInput.addEventListener('input', () => {
                        if (searchIcon && searchSpinner) {
                            searchIcon.classList.remove('opacity-100');
                            searchIcon.classList.add('opacity-0');
                            searchSpinner.classList.remove('opacity-0');
                            searchSpinner.classList.add('opacity-100');
                        }

                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            filterForm.submit();
                        }, 800);
                    });
                }
                
                // Immediate submit for combobox changes
                const hiddenInputs = filterForm.querySelectorAll('input[type="hidden"]');
                hiddenInputs.forEach(input => {
                    input.addEventListener('change', () => {
                        // Debounce slightly to allow UI animation before page freeze
                        setTimeout(() => filterForm.submit(), 150);
                    });
                });
            }
        });

        // --- Pagination Highlight on Scroll ---
        document.addEventListener('DOMContentLoaded', () => {
            const paginationTooltip = document.getElementById('pagination-tooltip');
            const paginationContainer = document.getElementById('pagination-container');
            const bottomAnchor = document.getElementById('bottom-anchor');
            
            if (paginationTooltip && paginationContainer && bottomAnchor) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const paginationButtons = document.getElementById('pagination-buttons');
                        if (entry.isIntersecting) {
                            paginationTooltip.classList.remove('opacity-0', '-translate-x-2');
                            paginationTooltip.classList.add('opacity-100', 'translate-x-0');
                            if (paginationButtons) paginationButtons.classList.add('ring-2', 'ring-indigo-500', 'ring-offset-2');
                        } else {
                            paginationTooltip.classList.remove('opacity-100', 'translate-x-0');
                            paginationTooltip.classList.add('opacity-0', '-translate-x-2');
                            if (paginationButtons) paginationButtons.classList.remove('ring-2', 'ring-indigo-500', 'ring-offset-2');
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe(bottomAnchor);
            }
        });

        // --- Realtime Clock Logic ---
        function updateRealtimeClock() {
            const now = new Date();
            
            // Format time: HH:MM:SS
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const clockEl = document.getElementById('realtime-clock');
            if (clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds}`;
            
            // Format date: Hari, DD Bulan YYYY
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            
            const dateEl = document.getElementById('realtime-date');
            if (dateEl) dateEl.textContent = `${dayName}, ${date} ${monthName} ${year}`;
        }
        
        // Initial call and set interval
        updateRealtimeClock();
        setInterval(updateRealtimeClock, 1000);

        // --- Custom Delete Modal Logic ---
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.btn-delete-barang');
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalContent = document.getElementById('delete-modal-content');
            const btnCancelDelete = document.getElementById('btn-cancel-delete');
            const btnConfirmDelete = document.getElementById('btn-confirm-delete');
            const deleteModalBackdrop = document.getElementById('delete-modal-backdrop');
            const deleteModalItemName = document.getElementById('delete-modal-item-name');
            let currentFormIdToSubmit = null;

            function showModal(formId, itemName) {
                currentFormIdToSubmit = formId;
                if(deleteModalItemName) deleteModalItemName.textContent = itemName;
                
                deleteModal.classList.remove('opacity-0', 'pointer-events-none');
                deleteModalContent.classList.remove('opacity-0', 'scale-95');
                deleteModalContent.classList.add('opacity-100', 'scale-100');
            }

            function hideModal() {
                currentFormIdToSubmit = null;
                deleteModal.classList.add('opacity-0', 'pointer-events-none');
                deleteModalContent.classList.remove('opacity-100', 'scale-100');
                deleteModalContent.classList.add('opacity-0', 'scale-95');
            }

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showModal(btn.dataset.formId, btn.dataset.barangName);
                });
            });

            if (btnCancelDelete) btnCancelDelete.addEventListener('click', hideModal);
            if (deleteModalBackdrop) deleteModalBackdrop.addEventListener('click', hideModal);
            
            if (btnConfirmDelete) {
                btnConfirmDelete.addEventListener('click', () => {
                    if (currentFormIdToSubmit) {
                        const form = document.getElementById(currentFormIdToSubmit);
                        if (form) {
                            btnConfirmDelete.disabled = true;
                            btnConfirmDelete.textContent = 'Menghapus...';
                            form.submit();
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
