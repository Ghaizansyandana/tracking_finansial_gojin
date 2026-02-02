<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunKeuangan extends Model
{
    use HasFactory;

    protected $table = 'akun_keuangan'; // Pastikan sesuai nama tabel di migrasi

    protected $fillable = [
        'nama_akun',
        'jenis',
        'saldo_awal',
        'saldo_saat_ini',
    ];
}