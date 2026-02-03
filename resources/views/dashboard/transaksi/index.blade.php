@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif
        <h4 class="fw-bold py-3 mb-0">Riwayat Transaksi</h4>
        <a href="{{ route('dashboard.transaksi.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Akun</th>
                        <th>Jumlah</th>
                        <th>Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $t)
                    <tr>
                        <td>
                            @if(\Carbon\Carbon::parse($t->tanggal)->isToday())
                                <span class="text-primary fw-bold">Hari Ini</span>
                            @elseif(\Carbon\Carbon::parse($t->tanggal)->isYesterday())
                                <span class="text-secondary">Kemarin</span>
                            @else
                                {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                            @endif
                        </td>
                        <td>{{ $t->kategori->nama }}</td>
                        <td>{{ $t->akun->nama_akun }}</td>
                        <td class="fw-bold">Rp {{ number_format($t->jumlah) }}</td>
                        <td>
                            <span class="badge {{ $t->jenis == 'pemasukan' ? 'bg-label-success' : 'bg-label-danger' }}">
                                {{ ucfirst($t->jenis) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection