<x-app-layout>
    <x-slot name="title">Barang Gadai</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Barang Gadai') }}
            </h2>
            <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 bg-zinc-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-800 focus:bg-zinc-800 active:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative flex items-center shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="block sm:inline font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border border-gray-200 shadow-sm sm:rounded-xl overflow-hidden">
                <!-- Header Card (Search & Filters) -->
                <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between bg-white">
                    <form method="GET" action="{{ route('barang.index') }}" class="w-full flex flex-col md:flex-row gap-3">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <x-text-input id="q" class="block w-full pl-10 text-sm" type="text" name="q" placeholder="Cari nama barang / nasabah..." value="{{ request('q') }}" />
                        </div>
                        
                        <!-- Filters -->
                        <div class="w-full md:w-48">
                            <select name="status" class="bg-white border-gray-300 text-gray-900 text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm">
                                <option value="">Semua Status</option>
                                @foreach(\App\Models\BarangGadai::STATUS as $stat)
                                    <option value="{{ $stat }}" {{ request('status') == $stat ? 'selected' : '' }}>{{ ucfirst($stat) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <select name="kategori" class="bg-white border-gray-300 text-gray-900 text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach(\App\Models\BarangGadai::KATEGORI as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <x-primary-button type="submit" class="!px-5 !py-2.5">Cari</x-primary-button>
                            @if(request()->anyFilled(['q', 'status', 'kategori']))
                                <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Nama Barang</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Taksiran Nilai</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Informasi Nasabah</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Tanggal / Tenor</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($barangGadai as $barang)
                                <tr class="bg-white hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $barang->nama_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                            {{ $barang->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        Rp {{ number_format($barang->taksiran_nilai, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $barang->nama_nasabah }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $barang->no_hp }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900">{{ $barang->tanggal_gadai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $barang->jangka_waktu }} Hari</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('barang._status-badge', ['status' => $barang->status])
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('barang.edit', $barang) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center border-b-0">
                                        @if(\App\Models\BarangGadai::count() === 0)
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data</h3>
                                                <p class="text-sm text-gray-500 mb-4 max-w-sm">Sistem belum memiliki data barang gadai satupun. Mulai tambahkan data pertama Anda.</p>
                                                <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 bg-zinc-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-800 transition ease-in-out duration-150 shadow-sm">
                                                    + Tambah Barang
                                                </a>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center justify-center py-6">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 mb-3">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                                <p class="text-gray-500 font-medium text-sm">Tidak ada barang yang cocok dengan filter pencarian Anda.</p>
                                                <a href="{{ route('barang.index') }}" class="mt-3 text-indigo-600 hover:text-indigo-800 text-sm font-medium">Reset Filter</a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                @if($barangGadai->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $barangGadai->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
