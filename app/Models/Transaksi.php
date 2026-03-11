<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    // Sesuai Migration Anda: 'transaksis' (pakai S)
    protected $table = 'transaksis';

    protected $fillable = [
        'user_id', 
        'judul', 
        'tipe', 
        'nominal', 
        'tanggal', 
        'catatan',
        'kategori_id',
        'akun_id',
        'payment_method_id'  // Add payment method relationship
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    /**
     * Get the payment method associated with the transaction.
     */
    public function paymentMethod()
    {
        // Pastikan foreign key-nya adalah payment_method_id sesuai hasil tinker tadi
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }
}