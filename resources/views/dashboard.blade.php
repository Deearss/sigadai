<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Kartu 1: Barang Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Barang Aktif</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $barangAktif }}</div>
                </div>

                <!-- Kartu 2: Total Taksiran Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Total Taksiran Aktif</div>
                    <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalTaksiranAktif, 0, ',', '.') }}</div>
                </div>

                <!-- Kartu 3: Kategori -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Kategori Barang</div>
                    <div class="mt-2 space-y-2">
                        @foreach (\App\Models\BarangGadai::KATEGORI as $kat)
                            <div class="flex justify-between items-center text-gray-700">
                                <span class="capitalize">{{ $kat }}</span>
                                <span class="font-bold">{{ $kategoriStats->get($kat, 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('barang.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Kelola Barang &rarr;
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
