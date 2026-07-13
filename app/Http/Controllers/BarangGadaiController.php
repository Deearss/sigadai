<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBarangGadaiRequest;
use App\Http\Requests\UpdateBarangGadaiRequest;

class BarangGadaiController extends Controller
{
    public function index()
    {
        $barangGadai = BarangGadai::latest()->paginate(10);
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
