<?php

namespace App\Http\Controllers\Dashboard; // Tambahkan \Dashboard

use App\Http\Controllers\Controller; // Tambahkan ini agar bisa extend Controller
use App\Models\Transaksi;

class DashboardController extends Controller
{
public function index()
{
    $userId = auth()->id();
    
    // Hitung TOTAL (Tanpa filter bulan agar kita cek datanya masuk atau tidak)
    $totalMasuk = Transaksi::where('user_id', $userId)->where('tipe', 'masuk')->sum('nominal');
    $totalKeluar = Transaksi::where('user_id', $userId)->where('tipe', 'keluar')->sum('nominal');
    $totalSaldo = $totalMasuk - $totalKeluar;

    // Hitung BULAN INI (Pastikan data di DB tanggalnya memang bulan ini)
    $pemasukanBulanIni = Transaksi::where('user_id', $userId)
        ->where('tipe', 'masuk')
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->sum('nominal');

        $pengeluaranBulanIni = Transaksi::where('user_id', $userId)
            ->where('tipe', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('nominal');

        $monthly = Transaksi::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym")
            ->selectRaw("SUM(CASE WHEN tipe = 'masuk' THEN nominal ELSE 0 END) as masuk")
            ->selectRaw("SUM(CASE WHEN tipe = 'keluar' THEN nominal ELSE 0 END) as keluar")
            ->where('user_id', $userId)
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $seriesMasuk = [];
        $seriesKeluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $ym = $month->format('Y-m');

            $labels[] = $month->format('M Y');
            $seriesMasuk[] = (float) (($monthly[$ym]->masuk ?? 0));
            $seriesKeluar[] = (float) (($monthly[$ym]->keluar ?? 0));
        }

        return view('dashboard.index', compact(
            'totalSaldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'labels',
            'seriesMasuk',
            'seriesKeluar'
        ));
    }
}