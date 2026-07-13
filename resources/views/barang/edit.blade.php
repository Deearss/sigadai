<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang Gadai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 max-w-2xl">
                    <form method="POST" action="{{ route('barang.update', $barang) }}">
                        @csrf
                        @method('PUT')
                        @include('barang._form', ['barang' => $barang])
                        
                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('barang.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
