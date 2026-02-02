<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function store(Request $request) 
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required|exists:kategori_keuangan,id',
            'akun_id' => 'required|exists:akun_keuangan,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan Transaksi
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'kategori_id' => $request->kategori_id,
                'akun_id' => $request->akun_id,
                'user_id' => auth()->id(), // Ambil ID user yang login
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);

            // 3. Update Saldo di Akun Keuangan
            $akun = AkunKeuangan::find($request->akun_id);
            if ($request->jenis == 'pemasukan') {
                $akun->increment('saldo_saat_ini', $request->jumlah);
            } else {
                $akun->decrement('saldo_saat_ini', $request->jumlah);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi berhasil dicatat!'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
