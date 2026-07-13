<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $barangAktif = BarangGadai::where('status', 'aktif')->count();
        $totalTaksiranAktif = BarangGadai::where('status', 'aktif')->sum('taksiran_nilai');
        
        $kategoriStats = BarangGadai::select('kategori')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('dashboard', compact('barangAktif', 'totalTaksiranAktif', 'kategoriStats'));
    }
}
