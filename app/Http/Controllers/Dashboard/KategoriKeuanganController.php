<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        $kategoris = KategoriKeuangan::all();
        return view('dashboard.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
        ]);

        KategoriKeuangan::create($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}