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
        $barangJatuhTempo = BarangGadai::where('status', 'aktif')
            ->where('tanggal_jatuh_tempo', '<=', today())
            ->count();
        $barangAktif = BarangGadai::where('status', 'aktif')
            ->where('tanggal_jatuh_tempo', '>', today())
            ->count();
        $barangDitebus = BarangGadai::where('status', 'ditebus')->count();
        $barangLelang = BarangGadai::where('status', 'lelang')->count();
        
        $totalTaksiranKeseluruhan = BarangGadai::sum('taksiran_nilai');
        // Aktif taksiran includes all active items (both regular and jatuh tempo)
        $totalTaksiranAktif = BarangGadai::where('status', 'aktif')->sum('taksiran_nilai');
        
        $kategoriStats = BarangGadai::select('kategori')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');
            
        $statusStats = [
            'Aktif' => $barangAktif,
            'Jatuh Tempo' => $barangJatuhTempo,
            'Ditebus' => $barangDitebus,
            'Lelang' => $barangLelang
        ];

        return view('dashboard', compact(
            'totalBarang', 'barangAktif', 'barangDitebus', 'barangJatuhTempo', 
            'totalTaksiranKeseluruhan', 'totalTaksiranAktif', 
            'kategoriStats', 'statusStats'
        ));
    }
}
