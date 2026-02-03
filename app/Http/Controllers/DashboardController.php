<?php

namespace App\Http\Controllers\Dashboard; // Tambahkan \Dashboard

use App\Http\Controllers\Controller; // Tambahkan ini agar bisa extend Controller
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = auth()->user();
        $totalSaldo = \App\Models\AkunKeuangan::sum('saldo_saat_ini');
        $pemasukanBulanIni = \App\Models\Transaksi::where('jenis', 'pemasukan')
                            ->whereMonth('tanggal', date('m'))
                            ->sum('jumlah');
        $pengeluaranBulanIni = \App\Models\Transaksi::where('jenis', 'pengeluaran')
                            ->whereMonth('tanggal', date('m'))
                            ->sum('jumlah');
        
        // Ambil 5 transaksi terakhir
        $transaksiTerakhir = \App\Models\Transaksi::with(['akun', 'kategori'])
                            ->latest('tanggal')
                            ->take(6)
                            ->get();

        return view('dashboard.index', compact(
            'user', 
            'totalSaldo', 
            'pemasukanBulanIni', 
            'pengeluaranBulanIni',
            'transaksiTerakhir'
        ));
    }
}