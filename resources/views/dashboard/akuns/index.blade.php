@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">Manajemen Akun</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
            <i class="bx bx-plus"></i> Tambah Akun
        </button>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Akun</th>
                        <th>Jenis</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Saat Ini</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($akuns as $akun)
                    <tr>
                        <td><strong>{{ $akun->nama_akun }}</strong></td>
                        <td><span class="badge bg-label-info">{{ ucfirst($akun->jenis) }}</span></td>
                        <td>Rp {{ number_format($akun->saldo_awal) }}</td>
                        <td class="text-primary fw-bold">Rp {{ number_format($akun->saldo_saat_ini) }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('dashboard.akuns.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Akun (Contoh: BCA / Dompet)</label>
                    <input type="text" name="nama_akun" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="tunai">Tunai</option>
                        <option value="bank">Bank</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Saldo Awal</label>
                    <input type="number" name="saldo_awal" class="form-control" placeholder="0" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection