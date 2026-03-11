<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\AkunKeuangan;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Calculate total balance
        $totalMasuk = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->sum('nominal');
            
        $totalKeluar = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'keluar')
            ->sum('nominal');
            
        $totalSaldo = $totalMasuk - $totalKeluar;

        // Calculate monthly income and expenses
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->toDateTimeString();
        $endOfMonth = $now->endOfMonth()->toDateTimeString();

        $pemasukanBulanIni = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'masuk')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('nominal');

        $pengeluaranBulanIni = Transaksi::where('user_id', $user->id)
            ->where('tipe', 'keluar')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('nominal');

        // Get recent transactions
        $transaksiTerakhir = Transaksi::where('user_id', $user->id)
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $monthly = Transaksi::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym")
            ->selectRaw("SUM(CASE WHEN tipe = 'masuk' THEN nominal ELSE 0 END) as masuk")
            ->selectRaw("SUM(CASE WHEN tipe = 'keluar' THEN nominal ELSE 0 END) as keluar")
            ->where('user_id', $user->id)
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

        return view('home', compact(
            'user',
            'totalSaldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerakhir',
            'totalMasuk',
            'totalKeluar',
            'labels',
            'seriesMasuk',
            'seriesKeluar'
        ));
    }
}