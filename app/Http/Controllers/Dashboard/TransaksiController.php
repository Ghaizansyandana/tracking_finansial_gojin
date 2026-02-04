<?php
namespace App\Http\Controllers\Dashboard; // Harus ada \Dashboard

use App\Http\Controllers\Controller; // Wajib di-import agar 'extends Controller' jalan
use App\Models\Transaksi;
use App\Models\AkunKeuangan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    public function index()
    {
        // Pastikan pakai paginate(jumlah_data), bukan get()
        $transaksis = Transaksi::latest()
                        ->paginate(10); // Menampilkan 10 data per halaman

        return view('dashboard.transaksi.index', compact('transaksis'));
    }
    
    public function create()
    {
        // Mengambil semua akun dan kategori agar muncul di pilihan dropdown
        $akuns = AkunKeuangan::all();
        $kategoris = KategoriKeuangan::all();
        
        return view('dashboard.transaksi.create', compact('akuns', 'kategoris'));
    }

    // app/Http/Controllers/Dashboard/TransaksiController.php

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => '    required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required',
            'akun_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Transaksi
            $transaksi = new Transaksi();
            $transaksi->tanggal = $request->tanggal;
            $transaksi->jenis = $request->jenis;
            $transaksi->kategori_id = $request->kategori_id;
            $transaksi->akun_id = $request->akun_id;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->keterangan = $request->keterangan;
            $transaksi->user_id = auth()->id(); // Mengambil ID admin/user yang sedang login
            $transaksi->save();

            // 2. Update Saldo Otomatis di Akun Keuangan
            $akun = AkunKeuangan::findOrFail($request->akun_id);
            
            if ($request->jenis == 'pemasukan') {
                $akun->saldo_saat_ini += $request->jumlah;
            } else {
                // Cek jika saldo cukup untuk pengeluaran
                if ($akun->saldo_saat_ini < $request->jumlah) {
                    throw new \Exception('Maaf, saldo ' . $akun->nama_akun . ' tidak mencukupi untuk transaksi ini.');
                }
                $akun->saldo_saat_ini -= $request->jumlah;
            }
            $akun->save();

            DB::commit();
            return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}