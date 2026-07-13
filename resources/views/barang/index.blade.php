<x-app-layout>
    <x-slot name="title">Barang Gadai</x-slot>
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

            <div class="mb-4 bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('barang.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <x-text-input id="q" class="block w-full" type="text" name="q" placeholder="Cari nama barang / nasabah..." value="{{ request('q') }}" />
                    </div>
                    <div class="w-full md:w-48">
                        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="">Semua Status</option>
                            @foreach(\App\Models\BarangGadai::STATUS as $stat)
                                <option value="{{ $stat }}" {{ request('status') == $stat ? 'selected' : '' }}>{{ ucfirst($stat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-48">
                        <select name="kategori" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\BarangGadai::KATEGORI as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-primary-button type="submit">Cari</x-primary-button>
                        <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Reset</a>
                    </div>
                </form>
            </div>

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
                                    <th scope="col" class="px-6 py-3">Tanggal / Tenor</th>
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
                                            <div class="text-xs text-gray-400 mt-1">{{ $barang->jangka_waktu }} Hari</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @include('barang._status-badge', ['status' => $barang->status])
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
                                            @if(\App\Models\BarangGadai::count() === 0)
                                                <div class="py-8">
                                                    <p class="mb-4 text-gray-600">Belum ada data barang gadai sama sekali di sistem.</p>
                                                    <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                                                        + Tambah Barang Pertama
                                                    </a>
                                                </div>
                                            @else
                                                Tidak ada barang yang cocok dengan pencarian.
                                            @endif
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
