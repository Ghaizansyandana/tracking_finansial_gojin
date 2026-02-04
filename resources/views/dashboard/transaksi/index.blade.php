@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Data /</span> Riwayat Transaksi</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bx bx-plus me-1"></i> Tambah Transaksi
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-primary alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($transaksis as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                        <td><strong>{{ $t->judul }}</strong></td>
                        <td>
                            @if($t->tipe == 'masuk')
                                <span class="badge bg-label-success">Pemasukan</span>
                            @else
                                <span class="badge bg-label-danger">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="{{ $t->tipe == 'masuk' ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ $t->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->nominal, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('dashboard.transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon text-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('dashboard.transaksi.modal-tambah') 
@endsection