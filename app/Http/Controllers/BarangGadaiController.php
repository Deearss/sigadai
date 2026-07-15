<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBarangGadaiRequest;
use App\Http\Requests\UpdateBarangGadaiRequest;

class BarangGadaiController extends Controller
{
    public function index(Request $request)
    {
        $barangGadai = BarangGadai::query()
            ->when($request->q, fn ($query, $q) => $query->where(fn ($w) =>
                $w->where('nama_barang', 'like', "%{$q}%")
                  ->orWhere('nama_nasabah', 'like', "%{$q}%")))
            ->when($request->status, function ($query, $s) {
                if ($s === 'jatuh_tempo') {
                    $query->where('status', 'aktif')
                          ->where('tanggal_jatuh_tempo', '<=', today());
                } elseif ($s === 'aktif') {
                    $query->where('status', 'aktif')
                          ->where('tanggal_jatuh_tempo', '>', today());
                } else {
                    $query->where('status', $s);
                }
            })
            ->when($request->kategori, fn ($query, $k) => $query->where('kategori', $k))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('barang.index', compact('barangGadai'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(StoreBarangGadaiRequest $request)
    {
        BarangGadai::create($request->validated());

        return redirect()->route('barang.index')->with('success', 'Barang gadai berhasil ditambahkan.');
    }

    public function edit(BarangGadai $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(UpdateBarangGadaiRequest $request, BarangGadai $barang)
    {
        $barang->update($request->validated());

        return redirect()->route('barang.index')->with('success', 'Barang gadai berhasil diperbarui.');
    }

    public function destroy(BarangGadai $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang gadai berhasil dihapus.');
    }
}
