<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKeuangan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Sesuai ERD Anda: 'kategori_keuangan'
     */
    protected $table = 'kategori_keuangan';

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'nama',
        'tipe',
    ];

    /**
     * Relasi: Satu kategori bisa digunakan oleh banyak transaksi.
     * (One-to-Many)
     */
    public function transaksi(): HasMany
    {
        // Parameter kedua adalah foreign key yang ada di tabel transaksi
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }

    /**
     * Scope untuk mempermudah filter berdasarkan tipe (Opsional tapi berguna)
     */
    public function scopePemasukan($query)
    {
        return $query->where('tipe', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('tipe', 'pengeluaran');
    }
}