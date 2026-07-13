<x-app-layout>
    <x-slot name="title">Tambah Barang Gadai</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Gadai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-xl border border-gray-200">
                <form method="POST" action="{{ route('barang.store') }}">
                    @csrf
                    <div class="p-8">
                        <div class="mb-8 border-b border-gray-100 pb-5">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Barang Gadai</h3>
                            <p class="text-sm text-gray-500 mt-1">Masukkan detail barang dan data nasabah dengan teliti sebelum disimpan ke sistem.</p>
                        </div>
                        
                        @include('barang._form')
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-5 flex items-center justify-end gap-3 rounded-b-xl border-t border-gray-100">
                        <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-primary-button>{{ __('Simpan Data') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
