<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Barang Gadai') }}
            </h2>
            <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Taksiran</th>
                                    <th scope="col" class="px-6 py-3">Nasabah</th>
                                    <th scope="col" class="px-6 py-3">No. HP</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Gadai</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangGadai as $barang)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $barang->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            {{ $barang->kategori }}
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp {{ number_format($barang->taksiran_nilai, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $barang->nama_nasabah }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $barang->no_hp }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $barang->tanggal_gadai->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 uppercase">
                                            {{ $barang->status }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('barang.edit', $barang) }}" class="font-medium text-blue-600 hover:underline mr-3">Edit</a>
                                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data barang gadai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $barangGadai->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
