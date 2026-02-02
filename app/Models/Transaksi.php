<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (opsional jika nama tabel sudah 'transaksis', 
    // tapi karena di ERD kamu 'transaksi', ini wajib ada)
    protected $table = 'transaksi';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori_id',
        'akun_id',
        'user_id',
        'jumlah',
        'keterangan',
    ];

    /**
     * Casting tipe data agar lebih mudah digunakan di Frontend/Logic.
     */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI ANTAR TABEL
    |--------------------------------------------------------------------------
    */

    /**
     * Menghubungkan transaksi ke User yang membuatnya.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Menghubungkan transaksi ke kategori (misal: Makan, Gaji).
     */
    public function kategori(): BelongsTo
    {
        // Parameter kedua adalah foreign_key di tabel transaksi
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    /**
     * Menghubungkan transaksi ke akun/dompet (misal: Bank, Cash).
     */
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }
}