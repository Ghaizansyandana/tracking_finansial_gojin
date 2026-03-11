<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::with('paymentMethod')->get();
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Judul', 'Tipe', 'Metode Pembayaran', 'Nominal'];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->id,
            $transaksi->tanggal,
            $transaksi->judul,
            $transaksi->tipe,
            $transaksi->paymentMethod->name ?? 'N/A',
            $transaksi->nominal,
        ];
    }
}