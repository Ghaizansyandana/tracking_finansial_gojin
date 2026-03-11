<!-- resources/views/dashboard/payment-methods/index.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h4 class="mb-0">Daftar Metode Pembayaran</h4>
                    <a href="{{ route('dashboard.payment-methods.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Metode
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Nama Akun</th>
                                    <th>Nomor Akun</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $method)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($method->logo)
                                            <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" width="44" class="rounded">
                                        @else
                                            <div class="bg-light d-inline-flex align-items-center justify-content-center p-2 rounded" style="width: 44px; height: 44px;">
                                                <i class="bx bx-credit-card"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $method->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $method->type === 'bank' ? 'primary' : 'success' }}">
                                            {{ ucfirst($method->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $method->account_name }}</td>
                                    <td>{{ $method->account_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $method->is_active ? 'success' : 'danger' }}">
                                            {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <a href="{{ route('dashboard.payment-methods.edit', $method) }}" class="btn btn-sm btn-warning">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('dashboard.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus metode ini?')">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data metode pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $paymentMethods->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection