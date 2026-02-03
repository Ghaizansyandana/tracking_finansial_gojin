<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        // Logic dummy (ganti dengan query database aslimu nanti)
        $totalSaldo = 1500000; 
        $pemasukanBulanIni = 500000;
        $pengeluaranBulanIni = 200000; // Siapkan sekalian siapa tahu Blade kamu butuh ini nanti

        // Kirim semua variabel ke view
        return view('home', compact(
            'user', 
            'totalSaldo', 
            'pemasukanBulanIni', 
            'pengeluaranBulanIni'
        ));
    }
}
