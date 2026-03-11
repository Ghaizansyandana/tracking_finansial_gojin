<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pemasukan { color: green; font-weight: bold; }
        .pengeluaran { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">RIWAYAT TRANSAKSI</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Tipe</th>
                <th>Metode Pembayaran</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- Pakai kolom 'tanggal' dari database --}}
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                
                {{-- Pakai kolom 'judul' --}}
                <td>{{ $item->judul }}</td>

                {{-- Pakai kolom 'tipe' --}}
                <td>{{ strtoupper($item->tipe) }}</td>

                {{-- Relasi payment_method --}}
                <td>{{ $item->paymentMethod->name ?? 'N/A' }}</td>
                {{-- Pakai kolom 'nominal' --}}
                <td style="color: {{ $item->tipe == 'masuk' ? 'green' : 'red' }}">
                    {{ $item->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>