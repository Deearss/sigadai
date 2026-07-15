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
        $totalBarang = BarangGadai::count();
        $barangAktif = BarangGadai::where('status', 'aktif')->count();
        $barangDitebus = BarangGadai::where('status', 'ditebus')->count();
        $barangJatuhTempo = BarangGadai::where('status', 'jatuh_tempo')->count();
        
        $totalTaksiranKeseluruhan = BarangGadai::sum('taksiran_nilai');
        $totalTaksiranAktif = BarangGadai::where('status', 'aktif')->sum('taksiran_nilai');
        
        $kategoriStats = BarangGadai::select('kategori')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');
            
        $statusStats = [
            'Aktif' => $barangAktif,
            'Ditebus' => $barangDitebus,
            'Jatuh Tempo' => $barangJatuhTempo
        ];

        return view('dashboard', compact(
            'totalBarang', 'barangAktif', 'barangDitebus', 'barangJatuhTempo', 
            'totalTaksiranKeseluruhan', 'totalTaksiranAktif', 
            'kategoriStats', 'statusStats'
        ));
    }
}
