<?php
namespace App\Http\Controllers\Dashboard;

// Baris di bawah ini adalah kunci untuk memperbaiki error Anda:
use App\Http\Controllers\Controller; 
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;

class AkunKeuanganController extends Controller
{
    public function index()
    {
        $akuns = AkunKeuangan::all();
        // Pastikan view diarahkan ke folder dashboard/akuns
        return view('dashboard.akuns.index', compact('akuns'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required',
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric',
        ]);

        AkunKeuangan::create([
            'nama_akun' => $request->nama_akun,
            'jenis' => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
            'saldo_saat_ini' => $request->saldo_awal, // INI PENTING: Isi saldo saat ini dengan saldo awal
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambah!');
    }
}