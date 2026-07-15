<x-app-layout>
    <x-slot name="title">Edit Barang Gadai</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-xl border border-gray-200">
                <form method="POST" action="{{ route('barang.update', $barang) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-8">
                        <div class="mb-8 border-b border-gray-100 pb-5">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Barang Gadai</h3>
                            <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada data barang atau ubah status gadai saat ini.</p>
                        </div>
                        
                        @include('barang._form', ['barang' => $barang])
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-5 flex items-center justify-end gap-3 rounded-b-xl border-t border-gray-100">
                        <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
