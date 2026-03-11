<?php
namespace App\Http\Controllers\Dashboard; // Harus ada \Dashboard

use App\Http\Controllers\Controller; // Wajib di-import agar 'extends Controller' jalan
use App\Models\Transaksi;
use App\Models\AkunKeuangan;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // Import Facade PDF
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    public function index()
    {
        // Eager load the paymentMethod relationship to prevent N+1 queries
        $transaksis = Transaksi::with('paymentMethod')
                        ->latest()
                        ->paginate(10); // Menampilkan 10 data per halaman

        return view('dashboard.transaksi.index', compact('transaksis'));
    }


    public function show($id)
    {
        // Jika ada yang akses rute detail, lempar balik ke daftar transaksi
        return redirect()->route('dashboard.transaksi.index');
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
        // 1. Validasi harus sesuai dengan atribut 'name' di Modal HTML
        $request->validate([
            'judul'            => 'required|string|max:255',
            'tipe'             => 'required|in:masuk,keluar',
            'nominal'          => 'required|numeric|min:1',
            'tanggal'          => 'required|date',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = new Transaksi();
            $transaksi->user_id = auth()->id();
            
            // 2. Petakan input Modal ke kolom Database (Migration)
            $transaksi->judul            = $request->judul;
            $transaksi->tipe             = $request->tipe;
            $transaksi->nominal          = $request->nominal;
            $transaksi->tanggal          = $request->tanggal;
            $transaksi->payment_method_id = $request->payment_method_id;
            $transaksi->save();

            // 3. Logika update saldo (Opsional, pastikan AkunKeuangan terkait sudah benar)
            // Jika Anda belum menangani pemilihan akun di modal, Anda bisa melewati bagian ini sementara
            /*
            $akun = AkunKeuangan::first(); // Contoh sederhana mengambil akun pertama
            if ($request->tipe == 'masuk') {
                $akun->saldo_saat_ini += $request->nominal;
            } else {
                $akun->saldo_saat_ini -= $request->nominal;
            }
            $akun->save();
            */

            DB::commit();
            return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($id);

            // Update Saldo Akun sebelum transaksi dihapus (Opsional/Sangat disarankan)
            $akun = AkunKeuangan::find($transaksi->akun_id);
            if ($akun) {
                if ($transaksi->tipe == 'masuk') {
                    $akun->saldo_saat_ini -= $transaksi->nominal;
                } else {
                    $akun->saldo_saat_ini += $transaksi->nominal;
                }
                $akun->save();
            }

            // Hapus data transaksi
            $transaksi->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil dihapus dan saldo telah diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function exportPdf() {
        // Kita panggil relasinya (asumsi nama relasi: paymentMethod)
        $data = Transaksi::with('paymentMethod')->get(); 

        $pdf = Pdf::loadView('dashboard.transaksi.pdf', compact('data'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel() {
        return Excel::download(new TransaksiExport, 'laporan-transaksi.xlsx');
    }
}