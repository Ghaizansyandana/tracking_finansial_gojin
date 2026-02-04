<?php
// homecontroller
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini jika pakai Query Builder
// use App\Models\Transaction; // Tambahkan ini jika kamu pakai Model Transaction

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user(); 
        $totalSaldo = DB::table('akun_keuangan')->sum('saldo_awal');

        // Gunakan JOIN untuk mengambil nama kategori
        // Ambil data transaksi saja tanpa join ke tabel kategori yang belum ada
        $transaksiTerakhir = DB::table('transaksi')
        ->latest()
        ->limit(5)
        ->get();
        
        $pemasukanBulanIni = DB::table('transaksi')
                            ->where('jenis', 'pemasukan')
                            ->whereMonth('created_at', date('m'))
                            ->sum('jumlah');

        $pengeluaranBulanIni = DB::table('transaksi')
                            ->where('jenis', 'pengeluaran')
                            ->whereMonth('created_at', date('m'))
                            ->sum('jumlah');

        return view('home', compact(
            'user', 
            'transaksiTerakhir', 
            'totalSaldo', 
            'pemasukanBulanIni',
            'pengeluaranBulanIni'
        ));
    }
}